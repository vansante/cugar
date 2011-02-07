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

	public function __construct(){
		//			DEBUG
		echo "Starting bootstrap \n";
		//			DEBUG

		//	Mount filesystem as read/write
		$this->readBaseXML();
		$this->prepInterface();
		$this->prepConfig();
		//			DEBUG
		echo "Bootstrap finished \n";
		//			DEBUG
	}

	/**
	 * Prep the network interfaces for data of config file
	 * @return void
	 * @throws Exception
	 */

	public function prepInterface(){
		echo "preparing network service \n";
		//Check if interface is up
		$networkinterface = $this->getInterfaceList();
		shell_exec( "/sbin/ifconfig " .$networkinterface[0]. " up" );

		//Set ip or DHPC on networkinterface
		if( $this->config->hardware->address['type'] == 'static') {
			//Set Ip Address
			shell_exec ( "/sbin/ifconfig " . ( string ) $networkinterface[0] . " " . ( string ) $this->config->hardware->address->ip. " netmask " . ( string )$this->config->hardware->address->subnet_mask );

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
				$error = ErrorStore::getInstance();
				throw new SystemError(ErrorStore::$E_FATAL,'Could not open /etc/resolv.conf for writing','500');
			}

			//	Set default route correctly
			shell_exec("/sbin/route add default ".$this->config->hardware->address->default_gateway );

		} else {
			//	Make /var/etc directory if it doesn't exist, otherwise fopen will fail miserably
			if(!is_dir('/var/etc/')){
				mkdir('/var/etc/');
			}

			// Set DHCP
			$fd = fopen ( "/var/etc/dhclient_" .$networkinterface[0]. ".conf", "w" );
			if($fd){
				$dhclientconf = "timeout 60;\n
	                retry 1;\n
	                select-timeout 0;\n
	                initial-interval 1;\n
	                interface \"" .$networkinterface[0]. "\" {\n
	                ".$this->config->hardware->hostname."\n
	                        script \"/sbin/dhclient-script\";\n
	                }";

				fwrite ( $fd, $dhclientconf );
				fclose ( $fd );

				shell_exec( "/sbin/dhclient -c /var/etc/dhclient_".$networkinterface[0].".conf ".$networkinterface[0]." >/tmp/ ".$networkinterface[0]."_output >/tmp/".$networkinterface[0]."_error_output" );
			}
			else{
				$error = ErrorStore::getInstance();
				throw new SystemError(ErrorStore::$E_FATAL,'Could not open /var/etc/dhclient_'.$networkinterface[0].'.conf for writing','500');
			}
		}

		if( $this->config->modes->mode_seletion == '3' || $this->config->modes->mode_seletion == '1_3' || $this->config->modes->mode_seletion == '2_3' ){
			//Write openvpn config
			$openvpnfile = fopen('/usr/local/etc/openvpn/openvpn.conf', 'w');
			if($openvpnfile){
				$openvpncontent = "client
				remote ".$SERVER_ADDR."
		
				port 1194
				proto tcp
				dev tun
		
				ca /etc/CUGAR/ca.crt
				cert /etc/CUGAR/".$this->config->modes->mode3->public_key.".crt
				key /etc/CUGAR/".$this->config->modes->mode3->private_key.".crt  # This file should be kept secret
		
				cipher AES-256-CBC   # AES
		
				verb 4
				";
				fwrite( $openvpnfile, $openvpncontent );
				fclose($openvpnfile);

				//Start openvpn
				shell_exec("/usr/local/sbin/openvpn file /usr/local/etc/openvpn/openvpn.conf");
			}
			else{
				$error = ErrorStore::getInstance();
				throw new SystemError(ErrorStore::$E_FATAL,'Could not open /usr/local/etc/openvpn.conf for writing','500');
			}
		}
	}

	/**
	 * Get interface list
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
	 * Prep the system for configuration
	 * @return void
	 * @throws Exception
	 */
	public function prepConfig(){
		echo "Preparing device configuration\n";
		if($this->config->modes->mode_selection == '3' || $this->config->modes->mode_selection == '1_3' || $this->config->modes->mode_selection == '2_3'){
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
				else{
					//	In modes 1 and 2 we need to transform the local config into the actual config
					$this->generateConfiguration();
				}

				$this->writeConfig();
			}
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

	}

	/**
	 * Merge local configuration with the server-side configuration
	 *
	 * @return void
	 */
	private function mergeConfiguration(){
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