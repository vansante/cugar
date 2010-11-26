<?php
class strict_rekey extends Statement{
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);
		
		$inst = HostAP::getInstance();
		$inst->setWpaStrictRekey((string)$options);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		if($options != 'true' && $options != 'false'){
			ParseErrorBuffer::addError('invalid strict rekey option',ParseErrorBuffer::$E_FATAL,$options);
		}
	}
}
?>