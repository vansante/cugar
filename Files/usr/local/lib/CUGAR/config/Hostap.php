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
 * Generates HostAP configuration from the XML
 *
 */
final class HostAP implements ConfigGenerator{
	/**
	 * Reference to self-instance for singleton
	 * @var HostAP
	 */
	private static $self;
	
	/**
	 * Buffer for config file contents
	 * @var String
	 */
	private $filebuffer;
	
	/**
	 * Path to save the config file to
	 * @var String
	 */
	private $FILEPATH = "/etc/";
	
	/**
	 * Filename of the config file
	 * @var String
	 */
	private $FILENAME = "hostap.conf";
	
	/**
	 * SSID name for current configuration block
	 * 
	 * Upon completion of the ssid block, this option is parsed into file format and loaded
	 * into $filebuffer
	 * 
	 * @var unknown_type
	 */
	private $ssid_name;
	
	public static function getInstance(){
		if(HostAP::$self == null){
			HostAP::$self = new HostAP();
		}
		return HostAP::$self; 
	}
	
	/**
	 * Private constructor because this is a singleton.
	 * @return unknown_type
	 */
	private function __construct(){
	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/config/ConfigGenerator#newSSID()
	 */
	public function newSSID(){
		//@TODO: Parse into file
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/config/ConfigGenerator#setSavePath()
	 */
	public function setSavePath($filepath){
		$this->FILEPATH = $filepath;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/config/ConfigGenerator#writeConfig()
	 */
	public function writeConfig(){
		$fp = fopen($this->FILEPATH,'w');
		if($fp){
			fwrite($fp,$this->buffer);
			fclose($fp);
		}
	}
	
	/**
	 * Set SSID name
	 * @param String $name
	 * @return void
	 */
	public function setSsidName($name){
		$this->ssid_name = $name;
	}
}