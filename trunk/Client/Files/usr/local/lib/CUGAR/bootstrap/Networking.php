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
 *	Networking Bootstrap class
 *
 *	Sets up pre-RC networking so we can fetch configuration do note that this networking
 *	information does not persist as-is after the script finishes, because RC restarts the networking daemon
 *	and as such information is overwritten by that in rc.conf.
 *	Although this should be identical as those parts of rc.conf are generated based on the same XML config.
 */
class Networking{
	/**
	 * Configuration block for interface
	 * @var SimpleXMLElement
	 */
	private $config;

	/**
	 * @return void
	 */
	public function __construct(){
		echo "preparing network service \n";
	}

	/**
	 * Setter for the configuration block
	 * @param SimpleXMLElement $config
	 * @return void
	 */
	public function setConfiguration($config){
		if($config == null){
			$ret = false;
		}
		else{
			$this->config = $config;
			$ret = true;
		}

		return $ret;
	}

	/**
	 * Check if the interface is up and running
	 *
	 * Does two simple checks to see if we have internet connectivity
	 * 1: See if the interface has an IP address
	 * 2: See if we can ping some arbitrary address with high uptime (say google DNS servers)
	 *
	 * @return boolean
	 */
	private function checkInterface($iface){
		$ret = true;
		
		$tmp = Functions::shellCommand( "/sbin/ifconfig " .$iface. " | /usr/bin/grep -w \"inet\" | /usr/bin/cut -d\" \" -f 2| /usr/bin/head -1" );
		$ip = str_replace ( "\n", "", $tmp );

		/*
		 * @TODO: Make this use those spiffy IP validation functions that can handle IPV4 and IPV6 later
		 */
		if(long2ip(ip2long($ip)) != $ip){
			//	We did not get a valid IPV4 address
			$ret = false;
		}
		
		/*	Do a ping of 8.8.8.8 and grep only the last output line, which contains the data we need
		 * 	This returns a line thusly:
		 *  1 packets transmitted, 0 packets received, 100.0% packet loss
		 *  
		 *  we can then use $output[23] to check if we received a reply because the reply string is of constant length.
		 *  It is of constant length because of the -t 1 flag which signals we are only sending one ping.
		 *  
		 *  using 8.8.8.8 is a liability and it is highly advisable to ping the server we make a tunnel to.
		 *  But unfortunately at development time testserver.cugar.org could not respond to ping due to environment
		 *  issues
		 *  
		 *  Possibly continuation of this test is a minor sleep command followed by a second (and perhaps a third) ping
		 *  test for a BO3 setting to reduce false negatives.
		 * 
		 */
		$output = Functions::shellCommand("ping -t 1 8.8.8.8 | grep received");
		if($output[23] == '0'){
			$ret = false;
		}
		
		return $ret;
	}

	/**
	 * prepare the interface for usage
	 *
	 * uses all the other functions in this class to do so, throws a SystemError upon failure
	 * returns true upon success.
	 *
	 * @throws SystemError
	 * @return boolean
	 */
	public function prepareInterface(){
		if($this->config == null){
			throw new SystemError(ErrorStore::$E_FATAL,'no device configuration was given to Networking block','504');
		}

		$iface = $this->getPrimaryInterface();
		$this->enableInterface($iface);

		//	Determine if we do DHCP or set static networking information
		if($this->config['type'] == 'static'){
			$this->setStaticAddress($iface);
		}
		else{
			$this->enableDHCP($iface);
		}
		
		if($this->checkInterface($iface) == true){
			return true;
		}
		else{
			throw new SystemError(ErrorStore::$E_FATAL,'Interface configuration failed','505');
		}
	}

	/**
	 * Sets up networking with a static IP address
	 *
	 * Also sets up the required routing and DNS components for a functional
	 * connection to the internet
	 *
	 * @throws SystemError
	 * @param String $iface
	 * @return void
	 */
	private function setStaticAddress($iface){
		//Set Ip Address
		Functions::shellCommand( "/sbin/ifconfig " . ( string ) $networkinterface[0] . " " . ( string ) $this->config->hardware->address->ip. " netmask " . ( string )$this->config->hardware->address->subnet_mask );

		//	Set DNS servers in resolv.conf
		$resolveconf = fopen('/etc/resolv.conf', 'w');
		if($resolveconf){
			$contents = "";
			foreach($this->config->hardware->address->dns_servers->ip as $dns) {
				$contents .= "nameserver ".(String)$dns."\n";
			}
			fwrite($resolveconf, $contents);
			fclose($resolveconf);
		}
		else{
			throw new SystemError(ErrorStore::$E_FATAL,'Could not open /etc/resolv.conf for writing','500');
		}

		//	Set default route correctly
		Functions::shellCommand("/sbin/route add default ".$this->config->hardware->address->default_gateway );
	}

	/**
	 * Writes out config and enables DHCP for $iface
	 *
	 * @throws SystemError
	 * @param String $iface
	 * @return void
	 */
	private function enableDHCP($iface){
		//	Make /var/etc directory if it doesn't exist, otherwise fopen will fail miserably
		if(!is_dir('/var/etc/')){
			mkdir('/var/etc/');
		}

		// Set DHCP
		$fd = fopen ( "/var/etc/dhclient_" .$iface. ".conf", "w" );
		if($fd){
			$dhclientconf = "timeout 60;
	                retry 1;
	                select-timeout 0;
	                initial-interval 1;
	                interface \"" .$iface. "\" {
	                ".$this->config->hardware->hostname."
	                        script \"/sbin/dhclient-script\";
	                }";

			fwrite ( $fd, $dhclientconf );
			fclose ( $fd );

			Functions::shellCommand( "/sbin/dhclient -c /var/etc/dhclient_".$iface.".conf ".$iface."");
		}
		else{
			$error = ErrorStore::getInstance();
			throw new SystemError(ErrorStore::$E_FATAL,'Could not open /var/etc/dhclient_'.$iface.'.conf for writing','500');
		}
	}


	/**
	 * Returns the primary interface's hardware identifier
	 *
	 * @return String
	 */
	private function getPrimaryInterface(){
		$networkinterface = Functions::getInterfaceList();
		return $networkinterface[1];
	}

	/**
	 * enables the hardware interface for usage
	 *
	 * throws SystemError when enabling of the interface fails.
	 *
	 * @param string $interface	hardware identifier of the interface
	 * @throws SystemError
	 * @return null
	 */
	private function enableInterface($interface){
		$output = Functions::shellCommand( "/sbin/ifconfig " .$interface. " up" );
		if(strlen($output) != 0){
			throw new SystemError(ErrorStore::$E_FATAL,"Enabling of interface ".$interface." failed with the following output: \n".$output);
		}
	}
}