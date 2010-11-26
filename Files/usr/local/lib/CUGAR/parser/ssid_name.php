<?php
class ssid_name extends Statement{
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);	
		
		//	Validation apparently succeeded, set the option in the hostAP config
		$inst = HostAP::getInstance();
		$inst->setSsidName((string)$options);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		if(!preg_match("/^[A-Za-z0-9\.]{1,32}$/",$options)){
			throw new MalformedConfigException($options,'invalid SSID name');
		}
	}
}