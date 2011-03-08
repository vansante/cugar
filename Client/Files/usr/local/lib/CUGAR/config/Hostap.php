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
	private $FILENAME = "hostapd.conf";

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

	private $ap_count;
	
	/**
	 * Array of bridges to make
	 * @var Array
	 */
	private $bridges;

	/**
	 * Get singleton instance
	 * @static
	 * @return HostAPDConfig
	 */
	public static function getInstance(){
		if(HostAPDConfig::$self == null){
			HostAPDConfig::$self = new HostAPDConfig();
		}
		return HostAPDConfig::$self;
	}

	/**
	 * Get the hardware interface for the current SSID
	 * the hardware interface is required by dhcp_relay and to set up
	 * the bridge with the openvpn interface or ethernet interface
	 *
	 * @return unknown_type
	 */
	public function getHardwareAddress(){
		if($this->ssid_count > 0){
			return 'wlan'.$this->ssid_count;
		}
		else{
			return 'wlan0';
		}
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

		$this->filebuffer .= "\n############ NEW SSID ##########\n";
	}

	public function finishSSID(){
		// Parse SSID spec and write to file buffer
		$this->parseBuffer();
		$this->ssid_count++;;
	}

	private function parseBuffer(){
		$rc = RCConfig::getInstance();
		if($this->ssid_count == 0){
			$this->filebuffer .= "ssid=".$this->ssid_name."\n";
			$this->filebuffer .= "channel=".$this->hw_channel."\n";
			if($this->hw_mode != 'n'){
				$this->filebuffer .= "hw_mode=".$this->hw_mode."\n";
			}
			else{
				$this->filebuffer .= "ieee80211n=1\n";
				//@TODO N is currently very very broken
			}
			
			$this->filebuffer .= "macaddr_acl=0\n";
				
			$this->filebuffer .= "ignore_broadcast_ssid=".(int)$this->broadcast_ssid."\n";
			$rc->addLine('hostapd_enable="YES"');
			$rc->addLine('create_args_wlan0="wlanmode hostap bssid"');
		}
		else{
			$this->filebuffer .="bss=wlan".$this->ssid_count."\n";
			$this->filebuffer .= "ssid=".$this->ssid_name."\n";
			$this->filebuffer .= "macaddr_acl=0\n";
			$this->filebuffer .= "ignore_broadcast_ssid=".(int)$this->broadcast_ssid."\n";
		
			$rc->addLine('create_args_wlan'.$this->ssid_count.'="wlanmode hostap bssid"');
		}

		if($this->ssid_mode == 3){
			$this->filebuffer .= "ieee8021x=1\n";
			$this->filebuffer .= "eapol_version=2\n";
			$this->filebuffer .= "eap_reauth_period=3600\n";
			$this->filebuffer .= "own_ip_addr=".$this->rad_own_ip."\n";
			$this->filebuffer .= "nas_identifier=".$this->rad_nas_identifier."\n";
			$this->filebuffer .= "auth_server_addr=".$this->rad_auth_ip."\n";
			$this->filebuffer .= "auth_server_port=".$this->rad_auth_port."\n";
			$this->filebuffer .= "auth_server_shared_secret=".$this->rad_auth_sharedsecret."\n";
			$this->filebuffer .= "acct_server_addr=".$this->rad_acct_ip."\n";
			$this->filebuffer .= "acct_server_port=".$this->rad_acct_port."\n";
			$this->filebuffer .= "acct_server_shared_secret=".$this->rad_acct_sharedsecret."\n";
			$this->filebuffer .= "radius_acct_interim_interval=".$this->rad_acct_interim_interval."\n";
			$this->filebuffer .= "radius_retry_primary_interval=".$this->rad_retry_interval."\n";
		}
		if($this->ssid_mode == 1){
			//		Mode 1 SSID, check WPA setting
			if($this->wpa_mode == 'wpa'){
				$this->filebuffer .= "wpa=0\n";
				$this->filebuffer .= "wpa_passphrase=".$this->wpa_passphrase."\n";
				$this->filebuffer .= "wpa_key_mgmt=WPA-PSK\n";
				$this->filebuffer .= "wpa_pairwise=TKIP CCMP\n";
				$this->filebuffer .= "wpa_group_rekey=".$this->wpa_group_rekey_interval."\n";
				$this->filebuffer .= "wpa_strict_rekey=".$this->wpa_strict_rekey."\n";
			}
			elseif($this->wpa_mode == 'wpa2'){
				$this->filebuffer .= "wpa=1\n";
				$this->filebuffer .= "wpa_passphrase=".$this->wpa_passphrase."\n";
				$this->filebuffer .= "wpa_key_mgmt=WPA-PSK\n";
				$this->filebuffer .= "rsn_pairwise=CCMP\n";
				$this->filebuffer .= "wpa_group_rekey=".$this->wpa_group_rekey_interval."\n";
				$this->filebuffer .= "wpa_strict_rekey=".$this->wpa_strict_rekey."\n";
			}
			//		For mode1, also set up the bridge between wlan0_x and primary ethernet interface
			$bridgeindex = count($this->bridges);
			$this->bridges[$bridgeindex][0] = "bridge".$bridgeindex;
			$this->bridges[$bridgeindex][1] = "wlan".$this->ssid_count;
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
		$rc = RCConfig::getInstance();
		$i = 0;
		$wanbuffer = null;
		while($i < $this->ap_count){
			if($i > 0){
				$wanbuffer .= " ";
			}
			$wanbuffer .= "wlan".$i."";
			
			$i++;
		}
		$rc->addLine('wlans_ath0="'.$wanbuffer.'"');
		
		$bridgeBuffer = null;
		$bridgeConfigBuffer = null;
		
		$i = 0;
		while($i < count($this->bridges)){
			if($i > 0){
				$bridgeBuffer .= " ";
			}
			$bridgeBuffer .= $this->bridges[$i][0];
			$array = Functions::getInterfaceList();
			$bridgeConfigBuffer .= "ifconfig_bridge0=\"addm ".$this->bridges[$i][1]." addm ".$array[0]." up\" \n";
			$i++;
		}
		$rc->addLine("cloned_interfaces=\"".$bridgeBuffer."\"");
		$rc->addLine($bridgeConfigBuffer);
		
		$fp = fopen($this->FILEPATH.$this->FILENAME,'w');
		if($fp){
			fwrite($fp,$this->filebuffer);
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
	 * set total number of access points
	 *
	 * @param unknown_type $number
	 * @return unknown_type
	 */
	public function setApNumber($number){
		$this->ap_count = $number;
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
		$this->rad_auth_ip = $ip;
	}

	/**
	 * set Port of authorization server
	 * @param Integer $port
	 */
	public function setRadiusAuthPort($port){
		$this->rad_auth_port = $port;
	}

	/**
	 * set Shared secret of authorization server
	 * @param String $secret
	 */
	public function setRadiusAuthSharedSecret($secret){
		$this->rad_auth_sharedsecret = $secret;
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