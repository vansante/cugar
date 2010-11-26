<?php
class vlan_id extends Statement{
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);
		$inst = HostAP::getInstance();
		$inst->setVlan((string)$options);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		if($options < 0 || $options > 4096){
			ParseErrorBuffer::addError('invalid vlan identifier',ParseErrorBuffer::$E_FATAL,$options);
		}
	}
}