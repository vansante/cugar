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
 * Pre-RC OpenVPN class
 *
 * Sets up OpenVPN for use prior to the execution of RC.
 * OpenVPN creates a tunnel to our management servers and fetches the device configuration
 * which will thereafter be parsed by the application.
 *
 */
class OpenVPNManager{
	/**
	 * Configuration block for interface
	 * @var SimpleXMLElement
	 */
	private $config;

	/**
	 * @return void
	 */
	public function __construct(){
		echo "preparing OpenVPN service \n";
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
	 * Prepare OpenVPN for business
	 * 
	 * @return void
	 */
	public function prepareOpenVPN(){
		$this->generateOpenVPNconfig();
		$this->startOpenVPN();
		
		if(!$this->checkOpenVPN()){
			throw new SystemError(ErrorStore::$E_FATAL,'OpenVPN initialization failed','507');
		}
	}
	
	/**
	 * Starts the OpenVPN service
	 * @return void
	 */
	private function startOpenVPN(){
		Functions::shellCommand("/usr/local/sbin/openvpn --config /etc/configtunnel/openvpn.conf --daemon >/dev/null 2>&1 &");
	}
	
	/**
	 * Check OpenVPN status
	 * 
	 * Checks OpenVPN status by
	 * 1: Assuring that there is a tun0 interface in existence
	 * 2: Asssuring we can ping the server
	 * If both of these tests succeed, it returns true. If either of them fail, return false.
	 * 
	 * @return boolean
	 */
	private function checkOpenVPN(){
		//@TODO: STUB
		$ret = true;
		return $ret;
	}

	/**
	 * Generate and write OpenVPN config
	 * @throws SystemError
	 * @return void
	 */
	private function generateOpenVPNconfig(){
		if($this->config == null){
			throw new SystemError(ErrorStore::$E_FATAL,'No config given to OpenVPN block','506');
		}
		
		//Write openvpn config
		if(!is_dir('/etc/configtunnel')){
			mkdir('/etc/configtunnel');
		}
			
		$openvpnfile = fopen('/etc/configtunnel/openvpn.conf', 'w');
		if($openvpnfile){
			$openvpncontent = "client
remote ".(string)$this->config->server."

ca /etc/CUGAR/ca.crt
cert /etc/CUGAR/".$this->config->public_key."
key /etc/CUGAR/".$this->config->private_key."

cipher AES-256-CBC

dev tun
proto tcp
port 1194

auth-nocache
script-security 2

verb 4";
			
			fwrite( $openvpnfile, $openvpncontent );
			fclose($openvpnfile);
		}
		else{
			throw new SystemError(ErrorStore::$E_FATAL,'Could not open /etc/openvpn.conf for writing','500');
		}
	}
}