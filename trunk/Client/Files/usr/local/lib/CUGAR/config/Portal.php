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
 * Captive portal configuration manager
 *
 * 
 */
class PortalConfig implements ConfigGenerator{
	private static $self;
	
	private $buffer;
	private $FILEPATH = "/etc/";
	private $FILENAME_MAIN = "main.conf";
	private $FILENAME_LOCAL = "local.conf";
	private $FILENAME_HS = "hs.conf";
	
	private $HTML_FILEPATH = "/var/www";
	
	/**
	 * The remote file that contains the captive portal HTML 
	 * @var String
	 */
	private $remote_file = null;
	
	/**
	 * Wlan interface the hotspot listens on
	 * @var String
	 */
	private $wlan_if;
	
	/**
	 * SSID name of the hotspot, used in directory names
	 * @var String
	 */
	private $ssid;
	
	/**
	 * Port number used by the lighttpd daemon internally
	 * incremented automatically
	 * @var integer
	 */
	private $PORT_NUMBER = 3990;
	
	/**
	 * Get singleton instance
	 * @static
	 * @return PortalConfig
	 */
	public static function getInstance(){
		if(PortalConfig::$self == null){
			PortalConfig::$self = new PortalConfig();
		}
		return PortalConfig::$self; 
	}
	
	/**
	 * Private constructor because this is a singleton.
	 * @return unknown_type
	 */
	private function __construct(){
		if(!is_dir($this->HTML_FILEPATH)){
			mkdir($this->HTML_FILEPATH);
		}
	}
	
	/**
	 * Clear the buffers for a new Captive Portal definition
	 */
	public function newPortal(){
		$this->wlan_if = null;
		$this->ssid = null;
		$this->remote_file = null;
	}
	
	/**
	 * Finish up the captive portal definition
	 */
	public function finishPortal(){
		$this->parseBuffer();
		$this->writeConfig();
		$http = LighttpdConfig::getInstance();
		$http = 
		$this->PORT_NUMBER++;
	}
	
	/**
	 * Set the SSID for the hotspot
	 * @param String $ssid
	 */
	public function setSSID($ssid){
		$this->ssid = $ssid;
	}
	
	/**
	 * Set WLAN interface
	 * @param String $wlan_if
	 */
	public function setWlanInterface($wlan_if){
		$this->wlan_if = $wlan_if;
	}
	
	/**
	 * Set the remote filename with this hotspot's HTML
	 * @param unknown_type $remoteFileName
	 */
	public function setRemoteFile($remoteFileName){
		$this->remote_file = $remoteFileName;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/config/ConfigGenerator#setSavePath()
	 */
	public function setSavePath($filepath){
		$this->FILEPATH = $filepath;
	}
	
	public function parseBuffer(){
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/config/ConfigGenerator#writeConfig()
	 */
	public function writeConfig(){
		//		@TODO: Fetch remote file!
		$this->remote_file;
		//		Extract remote file into directory
		
		//	Append rules to firewall because the application is too stupid to do it
		$fw = FirewallConfig::getInstance();
		$fw->addLine("pass tcp from any to any ".$this->portnumber." via ".$this->wlan_if);
		$fw->addLine("pass tcp from any to any 80 via ".$this->wlan_if." setup");
		$fw->addLine("pass tcp from any to any 443 via ".$this->wlan_if." setup");
		$fw->addLine("pass udp from any to any 53 via ".$this->wlan_if." keep-state");
		$fw->addLine("deny all from any to any via ".$this->wlan_if);
		
		
		Functions::shellCommand("mkdir ".$this->FILEPATH."hotspot_".$this->ssid);
		Functions::shellCommand("touch ".$this->FILEPATH."hotspot_".$this->ssid."/".$this->FILENAME_LOCAL);
		Functions::shellCommand("touch ".$this->FILEPATH."hotspot_".$this->ssid."/".$this->FILENAME_HS);
		
		//	Write out CoovaChilli configuration
		$fp = fopen($this->FILEPATH."hotspot_".$this->ssid."/".$this->FILENAME_MAIN,'w');
		if($fp){
			fwrite($fp,$this->buffer);
			fclose($fp);
		}
	}
}