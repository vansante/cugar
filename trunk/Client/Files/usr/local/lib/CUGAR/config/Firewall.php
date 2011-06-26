<?php
/**
 * Firewall class
 * 
 * Manages firewall rule contents, other configuration classes will insert their firewall lines
 * through this class to maintain file consistency and centralize file output.
 *
 */
class FirewallConfig implements ConfigGenerator{
	public static $self;
	
	private $buffer;
	private $ruleNumber;
	private $RULENUMBER_INCREMENT = 10;
	
	private $FILEPATH = "/etc/";
	private $FILENAME = "ipfw.rules";
	
	/**
	 * Get singleton instance
	 * @static
	 * @return RCConfig
	 */
	public static function getInstance(){
		if(FirewallConfig::$self == null){
			FirewallConfig::$self = new FirewallConfig();
		}
		return FirewallConfig::$self; 
	}
	
	/**
	 * 
	 */
	private function __construct(){
		$this->ruleNumber = '0';
		$this->buffer = '# Flush out the list before we begin.
ipfw -q -f flush

# Set rules command prefix
cmd="ipfw -q add"
		';
		
		$interfaces = Functions::getInterfaceList();	
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
		$this->buffer .= '$cmd '.$this->ruleNumber.' '.$line."\n";
		$this->ruleNumber += $this->RULENUMBER_INCREMENT;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/config/ConfigGenerator#writeConfig()
	 */
	public function writeConfig(){
		//	Add one last firewall rule in case none of the above match:
		$this->addLine("allow all from any to any");
		
		$fp = fopen($this->FILEPATH.$this->FILENAME,'w');
		if($fp){
			fwrite($fp,$this->buffer);
			fclose($fp);
		}
	}
}