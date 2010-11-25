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
	 * @var string
	 */
	private $ssid_name;
	
	/**
	 * Hardware mode the AP should run in 
	 * 
	 * 802.11a / 802.11b / 802.11g (a/b/g)
	 * @TODO N support momentarily suspended until suitable configuration can be tested
	 * 
	 * @var char
	 */
	private $hw_mode;
	
	/**
	 * Radio channel to broadcast on
	 * 
	 * @var int
	 */
	private $hw_channel;
	
	/**
	 * Determines whether we should broadcast this (B)SSID actively or not.
	 * 
	 * @var String true | false
	 */
	private $broadcast_ssid;
	
	/**
	 * vlan tag for outgoing traffic
	 * 
	 * @var integer
	 */
	private $vlan_id;
	
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
		//@TODO: Parse into file and reset object for new SSID spec
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
	 * 
	 * @param String $name
	 * @return void
	 */
	public function setSsidName($name){
		$this->ssid_name = $name;
	}
	
	/**
	 * Set operational mode (a/b/g)
	 * 
	 * @param char $mode
	 * @return void
	 */
	public function setMode($mode){
		$this->hw_mode = $mode;
	}
	
	/**
	 * Set the radio channel to operate on
	 * 
	 * @param integer $channel
	 * @return void
	 */
	public function setChannel($channel){
		$this->hw_channel = $channel;
	}
	
	/**
	 * Set whether to broadcast the (B)SSID or not
	 * 
	 * @param String $broadcast
	 * @return void
	 */
	public function setBroadcast($broadcast){
		$this->broadcast_ssid = $broadcast;
	}
	
	/**
	 * Set the VLAN id incoming traffic should be tagged with
	 * 
	 * @param integer $vlan_id
	 * @return void
	 */
	public function setVlan($vlan_id){
		$this->vlan_id = $vlan_id;
	}
}