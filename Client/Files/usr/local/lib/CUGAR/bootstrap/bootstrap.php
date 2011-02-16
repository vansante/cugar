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
 * Bootstrap class
 *
 * Activates at boot to fetch the configuration and
 * to do some base configuration required for the fetching of the configuration
 */
class BootStrap{

	/**
	 * Base XML config
	 *
	 * Configuration of system settings that are to be injected into
	 * the server side config XML if mode 3 is enabled
	 *
	 * @var SimpleXMLElement
	 */
	private $config;

	/**
	 * Server-side XML configuration
	 *
	 * Configuration fetched from the server, local configuration will
	 * be merged into this if a server configuration exists.
	 *
	 * @var SimpleXMLElement
	 */
	private $serverConfig;

	/**
	 * Filename of the base system config file
	 * @var String
	 */
	private $filename = 'sysconf.xml';

	/**
	 * Filepath to the base system config file
	 * @var String
	 */
	private $filepath = '/etc/CUGAR/';

	/**
	 * Initialize bootstrap and set some defaults
	 *
	 * @param integer $runmode	what mode to run in, toggles DEBUG flags and messages
	 * @return void
	 */
	public function __construct($runmode = 0){
		echo "Starting bootstrap \n";

		Functions::$runmode = $runmode;
		
		//	Mount filesystem as read/write
		$this->readBaseXML();
		$this->prepInterface();
		$this->prepConfig();

		echo "Bootstrap finished \n";
	}

	/**
	 * Prep the network for retrieving the config file
	 * 
	 * Sets up Networking and OpenVPN for configuration retrieval
	 * Exceptions are thrown by the objects that undertake this task
	 * 
	 * @return void
	 * @throws SystemError
	 */

	public function prepInterface(){
		try{
			//	Set up networking
			$network = new Networking();
			$network->setConfiguration($this->config->hardware->address);
			$networkready = $network->prepareInterface();

			if($networkready == true){
				if(stristr($this->config->modes->mode_selection,'3')){
					//	Set up OpenVPN
					$openvpn = new OpenVPNManager();
					$openvpn->setConfiguration($this->config->modes->mode3);
					$openvpn->prepareOpenVPN();
				}
			}
		}
		catch(SystemError $e){
			$error = ErrorStore::getInstance();
			$error->addError($e);
				
			Functions::debug($e->getMessage());
		}

	}

	
	/**
	 * Prep the system for configuration
	 * @return void
	 * @throws Exception
	 */
	public function prepConfig(){
		echo "Preparing device configuration\n";
		if($this->config->modes->mode_selection == '3' || $this->config->modes->mode_selection == '1_3' || $this->config->modes->mode_selection == '2_3'){
			echo "Mode 3 detected, fetching server configuration \n";
			//	Mode 3, fetch server-side config
			$fetch = new FetchConfig();
			$fetch->setConfigServer((string)$this->config->modes->mode3->tunnelIP);
			$fetch->setCertName((string)$this->config->modes->mode3->private_key);

			$this->serverConfig = $fetch->fetch();

			if(strlen($this->serverConfig) > 1){
				$this->serverConfig = simplexml_load_string($this->serverConfig);
				if($this->config->modes->mode_selection == '3' || $this->config->modes->mode_selection == '1_3' || $this->config->modes->mode_selection == '2_3'){
					//	In modes 3, 1_3 and 2_3 we need to merge the local config with the server config
					$this->mergeConfiguration();
				}

				$this->writeConfig();
			}
			else{
				throw new SystemError(ErrorStore::$E_FATAL,'Could not load config from server','500');
			}
		}
		else{
			//	In modes 1 and 2 we need to transform the local config into the actual config
			$this->generateConfiguration();
		}

	}

	/**
	 * Save merged configuration file to disk
	 *
	 * @return void
	 */
	private function writeConfig(){
		echo "Writing configuration to file\n";
		$fp = fopen($this->filepath.'config.xml',w);

		if($fp){
			fwrite($fp,$this->serverConfig->asXML());
			fclose($fp);
		}
		else{
			throw new SystemError(ErrorStore::$E_FATAL,'Could not open config file for writing','502');
		}
	}

	/**
	 * Transform sysconf.xml into proper configuration, required due to
	 * diverging XML specs (oops)
	 *
	 * @return unknown_type
	 */
	private function generateConfiguration(){
		echo "Preparing SSID configuration \n";
	}

	/**
	 * Merge local configuration with the server-side configuration
	 *
	 * @return void
	 */
	private function mergeConfiguration(){
		echo "Merging local and foreign configuration \n";
		$this->serverConfig->hardware->addChild('hostname',$this->config->hardware->hostname);
		$address = $this->serverConfig->hardware->addChild('address');
		$address->addAttribute('type',$this->config->hardware->address['type']);
		$address->addChild('subnet_mask',$this->config->hardware->address->subnet_mask);
		$address->addChild('ip',$this->config->hardware->address->ip);
		$address->addChild('default_gateway',$this->config->hardware->address->default_gateway);
		$dns = $address->addChild('dns_servers');

		foreach($this->config->hardware->address->dns_servers->ip as $ip){
			$dns->addChild('ip',(string)$ip);
		}

		if(isset($this->config->modes->mode1)){
			$tag = $this->serverConfig->addChild('ssid');
			$tag->addAttribute('mode','1');
			$hostapd = $tag->addChild('hostapd');

			$hostapd->addChild('ssid_name',$this->config->modes->mode1->ssid_name);
			$hostapd->addChild('broadcast','true');

			$wpa = $hostapd->addChild('wpa');
			$wpa->addAttribute('mode',$this->config->modes->mode1->wpa['mode']);
			$wpa->addChild('passphrase',$this->config->modes->mode1->wpa->passphrase);
			$wpa->addChild('strict_rekey','true');
			$wpa->addChild('group_rekey_interval','800');
		}
		if(isset($this->config->modes->mode2)){
			$tag = $this->serverConfig->addChild('ssid');
			$tag->addAttribute('mode','2');
			$hostapd = $tag->addChild('hostapd');

			$hostapd->addChild('ssid_name',$this->config->modes->mode1->ssid_name);
			$hostapd->addChild('broadcast','true');
		}
	}

	/**
	 * Fetch the base XML from file
	 * @return void
	 * @throws Exception
	 */
	public function readBaseXML(){
		echo "Reading sysconf.xml\n";
		if(file_exists($this->filepath.$this->filename)){
			//	Use custom error throwing for libxml
			$previouslibxmlSetting = libxml_use_internal_errors(true);

			$this->config = simplexml_load_file($this->filepath.$this->filename);

			//Failed loading the XML, throw excption.
			if (!$this->config){
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
}