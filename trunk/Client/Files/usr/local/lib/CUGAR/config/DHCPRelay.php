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
class DHCPRelayConfig implements ConfigGenerator{
	private static $self;
	
	private $buffer;
	private $FILENAME = "openvpn.conf";
	private $FILEPATH = "/etc/";
	
	private $hw_interface;
	private $servers;
	
	/**
	 * Get singleton instance
	 * @static
	 * @return DHCPRelay
	 */
	public static function getInstance(){
		if(DHCPRelay::$self == null){
			DHCPRelay::$self = new DHCPRelay();
		}
		return DHCPRelay::$self; 
	}
	
	/**
	 * Private constructor because this is a singleton.
	 * @return unknown_type
	 */
	private function __construct(){
	
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
	 * Set the hardware interface dhcprelay should bind to
	 * @param String $interface
	 */
	public function setInterface($interface){
		$this->hw_interface = $interface;
	}
	
	/**
	 * Add a DHCP server dhcprelay should forward to
	 * @param IP $interface
	 */
	public function addServer($ip){
		$this->servers[] = $ip;
	}
}