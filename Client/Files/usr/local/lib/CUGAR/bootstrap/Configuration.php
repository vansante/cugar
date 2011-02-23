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

abstract class configManager{
	/**
	 * Local configuration from the device
	 * @var SimpleXMLElement
	 */
	private $local_conf;

	/**
	 * Configuration fetched from the server
	 * @var SimpleXMLElement
	 */
	private $server_conf;

	/**
	 * Check configuration for changes
	 *
	 * Check if the configuration we are about to make is the same
	 * as the one we made previously. If so, abort and continue the boot process as normal.
	 * @return unknown_type
	 */
	abstract protected function checkConfigVersion();

	/**
	 * Setter for $this->local_conf
	 *
	 * @param SimpleXMLElement $local_conf
	 * @return void
	 */
	public function setLocalConf($local_conf){
		$this->local_conf = $local_conf;
	}

	/**
	 * Setter for $this->server_conf
	 *
	 * @param SimpleXMLElement $server_conf
	 * @return void
	 */
	public function setForeignConf($server_conf){
		$this->server_conf = $server_conf;
	}

	/**
	 * Write out xml configuration to file
	 *
	 * @throws SystemException
	 * @return unknown_type
	 */
	public function writeConfiguration(){
		echo "Writing configuration to file\n";
		$fp = fopen('/etc/CUGAR/config.xml',w);

		if($fp){
			fwrite($fp,$this->server_conf->asXML());
			fclose($fp);

			//	Copy the config xml to persistent storage on the /cfg slice of the device
			Functions::shellCommand('cp /etc/CUGAR/config.xml /cfg/CUGAR/config.xml');
		}
		else{
			throw new SystemError(ErrorStore::$E_FATAL,'Could not open config file for writing','502');
		}
	}
}

/**
 * Merge clientside configuration with Server-side configuration
 */
class MergeConfiguration extends configManager{

	public function __construct(){

	}

	/**
	 * Merge local configuration with the server imposed configuration
	 *
	 * @return unknown_type
	 */
	public function mergeConfiguration(){
		echo "Merging local and foreign configuration \n";
		$this->server_conf->hardware->addChild('hostname',$this->config->hardware->hostname);
		$address = $this->server_conf->hardware->addChild('address');
		$address->addAttribute('type',$this->config->hardware->address['type']);
		$address->addChild('subnet_mask',$this->config->hardware->address->subnet_mask);
		$address->addChild('ip',$this->config->hardware->address->ip);
		$address->addChild('default_gateway',$this->config->hardware->address->default_gateway);
		$dns = $address->addChild('dns_servers');

		foreach($this->config->hardware->address->dns_servers->ip as $ip){
			$dns->addChild('ip',(string)$ip);
		}

		if(isset($this->config->modes->mode1)){
			$tag = $this->server_conf->addChild('ssid');
			$tag->addAttribute('mode','1');
			$hostapd = $tag->addChild('hostapd');

			$hostapd->addChild('ssid_name',$this->local_conf->modes->mode1->ssid_name);
			$hostapd->addChild('broadcast','true');

			$wpa = $hostapd->addChild('wpa');
			$wpa->addAttribute('mode',$this->local_conf->modes->mode1->wpa['mode']);
			$wpa->addChild('passphrase',$this->local_conf->modes->mode1->wpa->passphrase);
			$wpa->addChild('strict_rekey','true');
			$wpa->addChild('group_rekey_interval','800');
		}
		if(isset($this->local_conf->modes->mode2)){
			$tag = $this->server_conf->addChild('ssid');
			$tag->addAttribute('mode','2');
			$hostapd = $tag->addChild('hostapd');

			$hostapd->addChild('ssid_name',$this->local_conf->modes->mode1->ssid_name);
			$hostapd->addChild('broadcast','true');
		}
	}

	protected function checkConfigVersion(){

	}

}