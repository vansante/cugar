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
final class HostAPDConfig implements ConfigGenerator{
	/**
	 * Reference to self-instance for singleton
	 * @var HostAP
	 * @static
	 */
	private static $self;
	
	/**
	 * 
	 * @var unknown_type
	 */
	private $ssid_count;
	
	/**
	 * Buffer for config file contents
	 * @var String
	 */
	private $filebuffer = "interface=wlan0
		driver=bsd
		logger_syslog=-1
		logger_syslog_level=2
		logger_stdout=-1
		logger_stdout_level=2";
	
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
	 * CUGAR mode the SSID runs in, used only to determine what values to ignore
	 * when parsing the config block
	 * @var Integer
	 */
	private $ssid_mode;
	
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
	 * @var string true | false
	 */
	private $broadcast_ssid;
	
	/**
	 * vlan tag for outgoing traffic
	 * 
	 * @var integer
	 */
	private $vlan_id;
	
	/**
	 * Do we want strict rekeying or not
	 * 
	 * @var string true | false
	 */
	private $wpa_strict_rekey;
	
	/**
	 * Passphrase to use for WPA / WPA2 auth on this (B)SSID
	 * @var string
	 */
	private $wpa_passphrase;
	
	/**
	 * Rekeying interval when using WPA/WPA2
	 * 
	 * @var integer
	 */
	private $wpa_group_rekey_interval;
	
	/**
	 * WPA mode setting
	 * 
	 * @var string
	 */
	private $wpa_mode;
	
	private $rad_own_ip;
	private $rad_nas_identifier;
	private $rad_retry_interval;
	
	private $rad_acct_ip;
	private $rad_acct_port;
	private $rad_acct_sharedsecret;
	private $rad_acct_interim_interval;
	
	private $rad_auth_ip;
	private $rad_auth_port;
	private $rad_auth_sharedsecret;
	
	/**
	 * Get singleton instance
	 * @static
	 * @return HostAP
	 */
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
		$this->ssid_count = 0;
	}
	
	/**
	 * 
	 */
	public function newSSID(){
		$this->ssid_count++;;
		
		//	Reset object for new SSID spec
		$ssid_name = null;
		$broadcast_ssid = null;
		$vlan_id = null;
		$wpa_strict_rekey = null;
		$wpa_passphrase = null;
		$wpa_group_rekey_interval = null;
		$wpa_mode = null;
		$rad_own_ip = null;
		$rad_nas_identifier = null;
		$rad_retry_interval = null;
		$rad_acct_ip = null;
		$rad_acct_port = null;
		$rad_acct_sharedsecret = null;
		$rad_acct_interim_interval = null;
		$rad_auth_ip = null;
		$rad_auth_port = null;
		$rad_auth_sharedsecret = null;
	}
	
	public function finishSSID(){
		// Parse SSID spec and write to file buffer
		$this->parseBuffer();
	}
	
	private function parseBuffer(){
		if($this->ssid_count == 0){
			$this->filebuffer .= "
			ssid=".$this->ssid_name."
			hw_mode=".$this->hw_mode."
			channel=".$this->hw_channel."
			macaddr_acl=0
			ignore_broadcast_ssid=".(int)$this->broadcast_ssid."";
		}
		else{
			$this->filebuffer .="
			bss=wlan0_".$this->ssid_count."
			ssid=".$this->ssid_name."
			macaddr_acl=0
			ignore_broadcast_ssid=".(int)$this->broadcast_ssid."
			";
		}
		
		if($this->ssid_mode == 3){
			$this->filebuffer .= "
			ieee8021x=1
			eapol_version=2
			eap_reauth_period=3600
			eap_server=0
			own_ip_addr=".$this->rad_own_ip."
			nas_identifier=".$this->rad_nas_identifier."
			
			auth_server_addr=".$this->rad_auth_ip."
			auth_server_port=".$this->rad_auth_port."
			auth_server_shared_secret=".$this->rad_auth_sharedsecret."
			acct_server_addr=".$this->rad_acct_ip."
			acct_server_port=".$this->rad_acct_port."
			acct_server_shared_secret=".$this->rad_acct_sharedsecret."
			radius_acct_interim_interval".$this->rad_acct_interim_interval."
			radius_retry_primary_interval=".$this->rad_retry_interval."
			";
		}
		if($this->ssid_mode == 1){
			if($this->wpa_mode == 'wpa'){
				$this->filebuffer .= "
				wpa=0
				wpa_passphrase=".$this->wpa_passphrase."
				wpa_key_mgmt=WPA-PSK
				wpa_pairwise=TKIP CCMP
				wpa_group_rekey=".$this->wpa_group_rekey_interval."
				wpa_strict_rekey=".$this->wpa_strict_rekey."
				";
			}
			elseif($this->wpa_mode == 'wpa2'){
				$this->filebuffer .= "
				wpa=1
				wpa_passphrase=".$this->wpa_passphrase."
				wpa_key_mgmt=WPA-PSK
				rsn_pairwise=CCMP
				wpa_group_rekey=".$this->wpa_group_rekey_interval."
				wpa_strict_rekey=".$this->wpa_strict_rekey."
				";
			}
		}
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
	 * Set SSID's CUGAR mode
	 *
	 * @param Integer $mode
	 * @return void
	 */
	public function setSsidMode($mode){
		$this->ssid_mode = $mode;
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
		if($broadcast == 'false'){
			$this->broadcast_ssid = 1;
		}
		else{
			$this->broadcast_ssid = 0;
		}
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
	
	/**
	 * set WPA / WPA2 Strict Rekeying option
	 * 
	 * @param String $strict_rekey
	 * @return void
	 */
	public function setWpaStrictReKey($strict_rekey){
		if($strict_rekey == 'true'){
			$this->wpa_strict_rekey = 1;
		}
		else{
			$this->wpa_strict_rekey = 0;
		}
	}
	
	/**
	 * Set WPA mode
	 * @param String $mode
	 * @return void
	 */
	public function setWpaMode($mode){
		$this->wpa_mode = $mode;
	}
	
	/**
	 * Set WPA / WPA2 Passphrase
	 * 
	 * @param String $passphrase
	 * @return void
	 */
	public function setWpaPassphrase($passphrase){
		$this->wpa_passphrase = $passphrase;
	}
	
	/**
	 * Set group rekey interval (seconds) for WPA/WPA2
	 * 
	 * @param int $interval
	 * @return void
	 */
	public function setWpaGroupRekeyInterval($interval){
		$this->wpa_group_rekey_interval = $interval;
	}
	
	/*
	 *	
	private $rad_auth_ip
	private $rad_auth_port;
	private $rad_auth_sharedsecret;
	 */
	
	/**
	 * set radius own IP
	 * @param IP $ip
	 */
	public function setRadiusOwnIp($ip){
		$this->rad_own_ip = $ip;
	}
	
	/**
	 * set Radius Retry interval
	 * @param Integer $interval
	 */
	public function setRadiusRetryInterval($interval){
		$this->rad_retry_interval = $interval;
	}
	
	/**
	 * Set NAS identifier
	 * @param String $nasid
	 */
	public function setRadiusNasIdentifier($nasid){
		$this->rad_nas_identifier = $nasid;
	}
	
	/**
	 * set IP of authorization server
	 * @param IP $ip
	 */
	public function setRadiusAuthIp($ip){
		$this->rad_acct_ip = $ip;
	}
	
	/**
	 * set Port of authorization server
	 * @param Integer $port
	 */
	public function setRadiusAuthPort($port){
		$this->rad_acct_port = $port;
	}
	
	/**
	 * set Shared secret of authorization server
	 * @param String $secret
	 */
	public function setRadiusAuthSharedSecret($secret){
		$this->rad_acct_sharedsecret = $secret;
	}
	
	/**
	 * set IP of accounting server
	 * @param IP $ip
	 */
	public function setRadiusAcctIp($ip){
		$this->rad_acct_ip = $ip;
	}
	
	/**
	 * set Port of accounting server
	 * @param Integer $port
	 */
	public function setRadiusAcctPort($port){
		$this->rad_acct_port = $port;
	}
	
	public function setRadiusAcctInterval($interval){
		$this->rad_acct_interim_interval = $interval;
	}
	
	/**
	 * set Shared secret of accounting server
	 * @param String $secret
	 */
	public function setRadiusAcctSharedSecret($secret){
		$this->rad_acct_sharedsecret = $secret;
	}
}