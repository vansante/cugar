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
class System implements ConfigGenerator{
	/**
	 * Reference to self
	 * @var System
	 */
	private static $self;
	
	/**
	 * System hostname
	 * @var string
	 */
	private $hostname;
	
	/**
	 * address type static | dhcp
	 * @var String
	 */
	private $addressType; 
	
	/**
	 * IP address to set
	 * only used with static address type
	 * @var IP
	 */
	private $address;
	
	/**
	 * subnet mask to set
	 * only used with static address type
	 * @var IP
	 */
	private $subnetmask;
	
	/**
	 * default gateway to use
	 * only used with static address type 
	 * @var IP
	 */
	private $defaultgateway;
	
	/**
	 * DNS servers
	 * only used with static address type (?)
	 * @var Array(IP)
	 */
	private $dns_servers;
	
	/**
	 * @return null
	 */
	private function __construct(){
		
	}
	
	
	
	/**
	 * set the hostname
	 * 
	 * @param unknown_type $hostname
	 * @return void
	 */
	public function setHostname($hostname){
		$this->hostname = $hostname;
	}
	
	/**
	 * Set the address type 
	 * 
	 * @param String $type (static | dhcp )
	 * @return void
	 */
	public function setAddressType($type){
		$this->addressType = $type;
	}
	
	/**
	 * Set the address
	 * 
	 * only used when $addressType = static
	 * 
	 * @param IP $address
	 * @return void
	 */
	public function setAddress($address){
		$this->address = $address;
	}
	
	/**
	 * 
	 * @param IP $netmask
	 * @return void
	 */
	public function setSubnetmask($netmask){
		$this->subnetmask = $netmask;
	}
	
	/**
	 * 
	 * @param IP $gateway
	 * @return void
	 */
	public function setDefaultGateway($gateway){
		$this->defaultgateway = $gateway;
	}
	
	/**
	 * Add a DNS server
	 * @param IP $server
	 * @return void
	 */
	public function addDNSserver($server){
		$this->dns_servers[] = $server;
	}
	
	/**
	 * Get instance of System
	 * @return System
	 */
	public static function getInstance(){
		if(System::$self == null){
			System::$self = new System();
		}
		return System::$self;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Client/Files/usr/local/lib/CUGAR/config/ConfigGenerator#setSavePath($path)
	 */
	public function setSavePath($filepath){}
	public function writeConfig(){}
}