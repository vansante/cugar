<?php
class group_rekey_interval extends Statement{
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);
		$inst = HostAP::getInstance();
		$inst->setWpaGroupRekeyInterval((string)$options);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		if(!is_numeric((int)$options)){
			ParseErrorBuffer::addError('group rekey interval has to be numeric',ParseErrorBuffer::$E_FATAL,$options);
		}
	}
}