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

	private $buffer;
	private $FILEPATH = "/etc/";
	private $FILENAME = "resolv.conf";

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
	 * Get a list of all hardware interfaces on the machine
	 * 
	 * @return Array
	 */
	public function getInterfaceList() {
		$i = 0;
		$interfaces = array();

		$temp = shell_exec('ifconfig');
		$temp = explode("\n",$temp);
		
		while($i < count($temp)){
			if(stristr($temp[$i],'flags')){
				$position = strpos($temp[$i],":",0);
				$tmp = substr($temp[$i],0,$position);

				if($tmp != 'lo0'){
					$interfaces[] = $tmp;
				}
			}
			$i++;
		}
		return $interfaces;
	}


	/**
	 * Start parsing of System configuration items
	 *
	 * Function does nothing now, but provides a possible future hook
	 * @return void
	 */
	public function startSystem(){

	}

	/**
	 * Ends parsing of System configuration items
	 *
	 * Function sets interface IP address configuration items in rc.conf
	 * DNS is written out separately (DNS is not part of rc)
	 * @return void
	 */
	public function endSystem(){
		$rc = RCConfig::getInstance();
		$interfaces = $this->getInterfaceList();
		$iface = $interfaces[0];

		if($this->addressType == 'dhcp'){
			//	set DHCP line for this interface
			$rc->addLine("ifconfig_".$iface.'="DHCP"');
		}
		else{
			//	set static IP line for this interface
			$rc->addLine("ifconfig_".$iface.'="inet '.$this->address.' netmask '.$this->subnetmask.'"'."\n");
			$rc->addLine('defaultrouter="'.$this->defaultgateway.'"'."\n");
		}
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
	public function setSavePath($filepath){
		$this->FILEPATH = $filepath;
	}

	public function writeConfig(){
		$fp = fopen($this->FILEPATH.$this->FILENAME,'w');
		if($fp){
			foreach($this->dns_servers as $server){
				$this->buffer .= "nameserver ".$server."\n";
			}
			fwrite($fp,$this->buffer);
			fclose($fp);
		}

	}
}