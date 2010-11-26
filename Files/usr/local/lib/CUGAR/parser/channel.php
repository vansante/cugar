<?php
class channel extends Statement{
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);	
		$inst = HostAP::getInstance();
		$inst->setChannel((string)$options);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		if($options < 1 || $options > 13){
			throw new MalformedConfigException($options,'Invalid channel selected '.$options);
		}
	}
}