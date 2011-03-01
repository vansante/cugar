<?php
/*
 All rights reserved.
 Copyright (C) 2010-2011 CUGAR
 All rights reserved.

 Redistribution and use in source and binary forms, with or without
 modification, are permitted provided that the following conditions are met:

 1. Redistributions of source code must retain the above copyright notice,
 this list of conditions and the following disclaimer.

 2. Redistributions in binary form must reproduce the above copyright
 notice, this list of conditions and the following disclaimer in the
 documentation and/or other materials provided with the distribution.

 THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES,
 INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 POSSIBILITY OF SUCH DAMAGE.
 */
/**
 * Centralized storage facility for all things configuration.
 */
class Configuration{
	/**
	 * Filename of the base system config file
	 * @var String
	 */
	private $local_conf_filename = 'sysconf.xml';

	/**
	 * Filename of server configuration file on local filesystem
	 * @var String
	 */
	private $server_conf_filename = 'serverconf.xml';

	/**
	 * Filename of merged configuration file
	 * @var String
	 */
	private $merged_conf_filename = 'config.xml';

	/**
	 * Filepath to the system config files
	 * @var String
	 */
	private $filepath = '/etc/CUGAR/';

	/**
	 * Reference to instance of self
	 * @var Configuration
	 */
	private static $ref;

	/**
	 * Local configuration
	 * @var SimpleXMLElement
	 */
	private $local_config;

	/**
	 * Configuration fetched from server
	 * @var SimpleXMLElement
	 */
	private $server_config;

	/**
	 * Merged configuration
	 * @var SimpleXMLElement
	 */
	private $merged_config;

	/**
	 * flag for reading locally saved server config file
	 * @var int
	 */
	public static $CONF_SOURCE_LOCAL = 1;
	/**
	 * flag for reading remote server config file
	 * @var int
	 */
	public static $CONF_SOURCE_REMOTE = 0;

	/**
	 * Private constructor because of singleton
	 * @return void
	 */
	private function __construct(){}

	/**
	 * Get the path to the configuration files
	 * @return String
	 */
	public function getfilepath(){
		return $this->filepath;
	}
	
	/**
	 * Fetch the local configuration XML from file
	 * @return void
	 * @throws SystemError
	 */
	public function readLocalConfiguration(){
		echo "Reading ".$this->filepath.$this->local_conf_filename."\n";
		if(file_exists($this->filepath.$this->local_conf_filename)){
			//	Use custom error throwing for libxml
			$previouslibxmlSetting = libxml_use_internal_errors(true);

			$this->local_config = simplexml_load_file($this->filepath.$this->local_conf_filename);

			//Failed loading the XML, throw excption.
			if (!$this->local_config){
				$message = "Failed to load configuration file {$file}. Invalid XML. ";
				foreach(libxml_get_errors() as $error) {
					$message .= $error->message;
				}

				libxml_clear_errors();
				throw new Exception($message);
			}

			//Set back to default error handling
			libxml_use_internal_errors($previouslibxmlSetting);
		}
		else{
			throw new Exception('XML file does not exist');
		}
	}


	/**
	 * Return local configuration object
	 * @return SimpleXMLObject
	 */
	public function getLocalConfiguration(){
		return $this->local_config;
	}


	/**
	 * Read server configuration from $source
	 *
	 * @param String $source $CONF_SOURCE_REMOTE | $CONF_SOURCE_LOCAL
	 * @return void
	 * @throws SystemError
	 */
	public function readServerConfiguration($source){
		if($source == Configuration::$CONF_SOURCE_REMOTE){
			$fetch = new FetchConfig();
			$fetch->setConfigServer((string)$this->local_config->modes->mode3->tunnelIP);
			$fetch->setCertName((string)$this->local_config->modes->mode3->private_key);
			$xmlstring = $fetch->fetch();
			
			if(strlen($xmlstring) > 0){
				libxml_use_internal_errors (true);
				$this->server_config = simplexml_load_string($xmlstring);
				if(count(libxml_get_errors()) > 0){
					foreach(libxml_get_errors() as $error){
						$errorstore = ErrorStore::getInstance();
						$errorstore->addError(new SystemError(ErrorStore::$E_WARNING,print_r($error),'666'));
					}
					libxml_clear_errors();
					throw new SystemError(ErrorStore::$E_FATAL,'error loading remote xml','999');
				}

			}
			else{
				throw new SystemError(ErrorStore::$E_FATAL,'Could not load config from server','500');
			}
		}
		elseif($source == Configuration::$CONF_SOURCE_LOCAL){
			echo "Reading ".$this->filepath.$This->server_conf_filename."\n";
			if(file_exists($this->filepath.$this->server_conf_filename)){
				//	Use custom error throwing for libxml
				$previouslibxmlSetting = libxml_use_internal_errors(true);
				$this->server_config = simplexml_load_file($this->filepath.$this->server_conf_filename);

				//Failed loading the XML, throw excption.
				if (!$this->server_config){
					$message = "Failed to load configuration file {$file}. Invalid XML. ";
					foreach(libxml_get_errors() as $error) {
						$message .= $error->message;
					}

					libxml_clear_errors();
					throw new SystemError(ErrorStore::$E_FATAL,$message,'700');
				}
				//Set back to default error handling
				libxml_use_internal_errors($previouslibxmlSetting);
			}
			else{
				throw new SystemError(ErrorStore::$E_FATAL,'Could not load '.$this->filepath.$this->server_conf_filename.' for reading','404');
			}
		}
	}


	/**
	 * Return server configuration object
	 * @return SimpleXMLElement
	 */
	public function getServerConfiguration(){
		return $this->server_config;
	}


	/**
	 *
	 * @return void
	 * @throws SimpleXMLElement
	 */
	public function readMergedConfiguration(){
		echo "Reading ".$this->filepath.$this->merged_conf_filename."\n";
		if(file_exists($this->filepath.$this->merged_conf_filename)){
			//	Use custom error throwing for libxml
			$previouslibxmlSetting = libxml_use_internal_errors(true);

			$this->local_config = simplexml_load_file($this->filepath.$this->merged_conf_filename);

			//Failed loading the XML, throw excption.
			if (!$this->local_config){
				$message = "Failed to load configuration file {$file}. Invalid XML. ";
				foreach(libxml_get_errors() as $error) {
					$message .= $error->message;
				}

				libxml_clear_errors();
				throw new Exception($message);
			}

			//Set back to default error handling
			libxml_use_internal_errors($previouslibxmlSetting);
		}
		else{
			throw new Exception('XML file does not exist');
		}
	}


	/**
	 * Return merged configuration object
	 * @return SimpleXMLElement
	 */
	public function getMergedConfiguration(){
		return $this->merged_config;
	}

	/**
	 * Reference retrieval for singleton
	 * @return Configuration
	 */
	public static function get(){
		if(Configuration::$ref == null){
			Configuration::$ref = new Configuration();
		}
		return Configuration::$ref;
	}
}