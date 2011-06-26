<?php
class remote_file extends Statement{
	/**
	 * Constructor
	 *
	 * @param Array $parse_opt
	 * @return void
	 */
	public function __construct($parse_opt){
		$this->parse_options = $parse_opt;
	}
	
	public function interpret($options){
		$this->validate($options);	
		$hp = PortalConfig::getInstance();
		$hp->setRemoteFile((string)$options);
	}
	
	public function validate($options){
		
	}
}