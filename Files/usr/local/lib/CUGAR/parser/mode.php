<?php
class mode extends Statement{
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);
		$inst = HostAP::getInstance();
		$inst->setMode((string)$options);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		// @TODO: N configuration is apparently very different, dropped support momentarily
		$allowed_values = array('a','b','g');
		if(!in_array((string)$options,$allowed_values)){
			ParseErrorBuffer::addError('invalid mode selected',ParseErrorBuffer::$E_FATAL,$options);
		}
	}
}