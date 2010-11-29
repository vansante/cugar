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
 * XML Parser class for the client
 */
class XMLParser{
	public static $_WRITE_CONFIG = 0;
	public static $_VALIDATE_CONFIG = 1;
	
	/**
	 * @var XMLObject
	 * @access private
	 */
	private $xml;
	
	/**
	 * @var String filepath
	 * @access private
	 */
	private $filepath;

	/**
	 * Parse Options
	 * 
	 * ['mode'] Parse mode, either _WRITE_CONFIG or _VALIDATE_CONFIG
	 * 
	 * @var String $mode
	 */
	private $options;
	
	/**
	 * 
	 */
	public function __construct(){
		
	}
	
	/**
	 * Set parse mode
	 * 
	 * @param String $mode
	 * @return void
	 */
	public function setMode($mode){
		$this->options['mode'] = $mode;
	}
	
	/**
	 * Set the error level
	 * @param int $errorlevel
	 * @return unknown_type
	 */
	public function setErrorLevel($errorlevel){
		$this->options['errorlevel'] = $errorlevel;
	}

	/**
	 * load XML from file
	 * 
	 * @param $file 	filepath/name of file to load
	 */
	public function loadXML($file){
		//	Use custom error throwing for libxml
		$previouslibxmlSetting = libxml_use_internal_errors(true);
		
		$this->xml = simplexml_load_file($file);
		$this->file = $file;

		//Failed loading the XML, throw excption.
		if (!$this->xml){
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

	/**
	 * 
	 * @return unknown_type
	 */
	public function parse(){
		try{
			/*	Parser cascades down through Statement classes until it has parsed everything
			 * 	as such, over here, we only have to call the ssid class every time we encounter an ssid tag.
			 * 
			 * 	@TODO: theoretically, we might want to add a config statement for the root tag handling / validation
			 *  which would ensure ssid tags are present (what good is an empty device)
			 *  that's mostly something that impacts design, rather than functionality. So it's omitted at this time.
			 */
			foreach($this->xml->ssid as $tag){
				//	First instantiate new SSID stuff for each config block (where appliccable)
				
				//	Parse SSID statement and go through validation
				$tmp = new ssid($this->options);
				$tmp->interpret($tag);
			}
			
			/*
			 * Now that we've parsed the entire thing, check if we had any errors
			 */
			if(ParseErrorBuffer::hasErrors($this->options['errorlevel'])){
				if($this->options['mode'] == 'validate'){
					ParseErrorBuffer::printErrors($this->options['errorlevel']);
				}
			}
			else{
				echo 'parsing complete';
			}
		}
		catch(SystemError $e){
			print_r($e);
		}
		catch(MalformedConfigException $e){
			/**
			 * @TODO: What do we want on error, stop parsing entirely (current behavior) or
			 * do we want to prevent parsing of the SSID that failed validation? (slightly more annoying as it requires double-buffering, but not impossible)
			 * 
			 * Behavior would probably also differ in different modes, parsing should probably continue in VALIDATE mode, and should simply log all the errors.
			 * Will need to rerouteslightly at that point since exceptions break the cascade-down unless handled in a lower tier.
			 * 
			 * Make sure to inquire.
			 */
			print_r($e);
		}
	}
}