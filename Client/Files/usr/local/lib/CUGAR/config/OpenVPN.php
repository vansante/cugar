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
 * Generates OpenVPN configuration from the XML
 *
 */
class OpenVPNConfig implements ConfigGenerator{
	/**
	 * Reference to self (for singleton)
	 * @var OpenVPN
	 * @static
	 * @access private
	 */
	private static $self;

	/**
	 * File buffer
	 * @var unknown_type
	 */
	private $buffer;

	/**
	 * Path to save the config file(s) to
	 * @var String
	 * @static
	 */
	private static $FILEPATH = "/etc/";

	/**
	 * Name of file to write to.
	 * @var unknown_type
	 */
	private $filename = 'openvpn';

	/**
	 * tunnel type (data / auth)
	 * @var String
	 */
	private $tunnel_type;

	/**
	 * Cipher (any supported cipher)
	 * @var String
	 */
	private $cipher;

	/**
	 * Enable compression
	 * @var Boolean
	 */
	private $compression;

	/**
	 * Address of the server to connect to
	 *
	 * IP or domain name
	 *
	 * @var String
	 */
	private $server;

	/**
	 * Port to connect on
	 * @var Integer
	 */
	private $port;

	/**
	 * tunnel counter, keeps track of how many tunnels
	 * already exist, used to write out more than one config file
	 *
	 * @TODO after generation it'll be impossible to know what tunnel belongs to what
	 * hell it's already hard enough to figure it out at this stage
	 * @var Integer
	 */
	private $tunnelcount = 0;

	/**
	 * OpenVPN verbose setting
	 * Verbosity setting to give to the OpenVPN daemon, 3 is normal >3 is more verbose
	 * @var Integer
	 */
	private $verbosity = 3;

	/**
	 * Certificate authority filename
	 * @var String
	 */
	private $caname;

	/**
	 * Certificate authority contents
	 * @var String
	 */
	private $ca;

	/**
	 * private key filename
	 * @var String
	 */
	private $keyname;
	/**
	 * private key contents
	 * @var String
	 */
	private $key;

	/**
	 * public key filename
	 * @var String
	 */
	private $certname;

	/**
	 * public key contents
	 * @var String
	 */
	private $cert;

	/**
	 * Get singleton instance
	 * @static
	 * @return OpenVPNConfig
	 */
	public static function getInstance(){
		if(OpenVPNConfig::$self == null){
			OpenVPNConfig::$self = new OpenVPNConfig();
		}
		return OpenVPNConfig::$self;
	}

	/**
	 *
	 */
	private function __construct(){}

	/**
	 *
	 * @param String $filename
	 * @param String $contents
	 * @return null
	 */
	public function setCA($filename,$contents){
		$this->caname = $filename;
		$this->ca = $contents;
	}

	/**
	 *
	 * @param String $filename
	 * @param String $contents
	 * @return null
	 */
	public function setKey($filename,$contents){
		$this->keyname = $filename;
		$this->key = $contents;
	}

	/**
	 *
	 * @param String $filename
	 * @param String $contents
	 * @return null
	 */
	public function setCert($filename,$contents){
		$this->certname = $filename;
		$this->cert = $contents;
	}

	/**
	 * Set the tunnel type
	 * @param String $type
	 */
	public function setTunnelType($type){
		$this->tunnel_type = $type;
	}

	/**
	 * set the OpenVPN cipher
	 * @param String $cipher
	 * @return void
	 */
	public function setCipher($cipher){
		$this->cipher = $cipher;
	}

	/**
	 * Enable / Disable compression
	 * @param Boolean $compression
	 */
	public function setCompression($compression){
		if($compression == 'true'){
			$this->compression = true;
		}
		else{
			$this->compression = false;
		}
	}

	/**
	 * Set the server
	 * @param String $server
	 */
	public function setServer($server){
		$this->server = $server;
	}

	/**
	 * Set the port
	 * @param Integer $port
	 */
	public function setPort($port){
		$this->port = $port;
	}

	/**
	 * New Tunnel
	 *
	 * Write filebuffer to file
	 * Increment tunnel count
	 * flush filebuffer
	 *
	 * @return void
	 */
	public function newTunnel(){
		$this->buffer = '';
		$this->tunnel_type = null;
		$this->cipher = null;
		$this->server = null;
		$this->port = null;
	}

	/**
	 * End of a tunnel spec, all the required variables are now filled
	 * and we can parse all the variables into our config file.
	 *
	 * @TODO What will we do about certificates? (possible issue)
	 * @return void
	 */
	public function endTunnel(){
		$this->buffer .= "client\n";
		$this->buffer .= "remote ".$this->server."\n\n";
		$this->buffer .= "cipher ".$this->cipher."\n";
		$this->buffer .= "link-mtu 1559\n\n";
		$this->buffer .= "dev tun\n

proto tcp-client
port ".$this->port."
		
ca /etc/openvpn".$this->tunnelcount."/".$this->caname."
cert /etc/openvpn".$this->tunnelcount."/".$this->certname."
key /etc/openvpn".$this->tunnelcount."/".$this->keyname."

user nobody
group nobody
verb ".$this->verbosity."\n";

		if($this->compression){
			$this->buffer .= "comp-lzo\n";
		}

		$this->writeConfig();
		$this->tunnelcount++;
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
		if(!is_dir(OpenVPNConfig::$FILEPATH."openvpn".$this->tunnelcount."/")){
			mkdir(OpenVPNConfig::$FILEPATH."openvpn".$this->tunnelcount."/");
		}
		
		$fp = fopen(OpenVPNConfig::$FILEPATH."openvpn".$this->tunnelcount."/".$this->keyname,'w');
		if($fp){
			fwrite($fp,$this->key);
			fclose($fp);
		}

		$fp = fopen(OpenVPNConfig::$FILEPATH."openvpn".$this->tunnelcount."/".$this->certname,'w');
		if($fp){
			fwrite($fp,$this->cert);
			fclose($fp);
		}

		$fp = fopen(OpenVPNConfig::$FILEPATH."openvpn".$this->tunnelcount."/".$this->caname,'w');
		if($fp){
			fwrite($fp,$this->ca);
			fclose($fp);
		}

		$fp = fopen(OpenVPNConfig::$FILEPATH."openvpn".$this->tunnelcount."/".$this->filename.$this->tunnelcount.'.conf','w');
		if($fp){
			fwrite($fp,$this->buffer);
			fclose($fp);
		}
	}
}