<?php
/**
 * RC class
 * 
 * Manages rc.conf contents, other configuration classes will insert their rc.conf lines
 * through this class to maintain consistency.
 *
 */
class RCConfig implements ConfigGenerator{
	public static $self;
	
	private $buffer;
	private $FILEPATH = "/etc/";
	private $FILENAME = "rc.conf";
	
	/**
	 * Get singleton instance
	 * @static
	 * @return RCConfig
	 */
	public static function getInstance(){
		if(RCConfig::$self == null){
			RCConfig::$self = new RCConfig();
		}
		return RCConfig::$self; 
	}
	
	/**
	 * 
	 */
	private function __construct(){
		//@TODO remove on completion of debug?
		$this->addLine("firewall_enable=\"YES\""); 
		$this->addLine("firewall_type=\"/etc/ipfw.rules\"");
		$this->addLine("sshd_enable=\"YES\"");
		$this->addLine("gateway_enable=\"YES\"");
		//		Static services that must be started always
		$this->addLine("snmpd_enable=\"YES\"");
		$this->addLine("snmpd_conffile=\"/etc/snmpd.conf\"");
		$this->addLine("lighttpd_enable=\"YES\"");
		$this->addLine("ntpdate_enable=\"YES\"");
		$this->addLine('ntpdate_hosts="nl.pool.ntp.org"');
		$this->addLine("openvpn_enable=\"YES\"");
		$this->addLine("openvpn_bridges_enable=\"YES\"");
		$this->addLine('hostapd_enable="YES"');
		$this->addLine('dnsmasq_enable="YES"');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/config/ConfigGenerator#setSavePath()
	 */
	public function setSavePath($filepath){
		$this->FILEPATH = $filepath;
	}
	
	/**
	 * Add a line to RC.conf 
	 * 
	 * @param String $line
	 * @return void
	 */
	public function addLine($line){
		$this->buffer .= $line."\n";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/config/ConfigGenerator#writeConfig()
	 */
	public function writeConfig(){
		$fp = fopen($this->FILEPATH.$this->FILENAME,'w');
		if($fp){
			fwrite($fp,$this->buffer);
			fclose($fp);
		}
	}
}