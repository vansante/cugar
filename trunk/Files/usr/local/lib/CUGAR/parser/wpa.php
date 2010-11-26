<?php
class wpa extends Statement{
	/**
	 * Expected child nodes for this statement
	 * @var Array
	 */
	private $expected_tags = array('passphrase','strict_rekey','group_rekey_interval');
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);
		
		$inst = HostAP::getInstance();
		$inst->setWpaMode($options['mode']);
		
		foreach($options->children() as $child){
			$name = $child->getName();
			if(class_exists($name)){
				$tmp = new $name();
				$tmp->interpret($child);
			}
			else{
				throw new SystemError('could not find class '.$name);
			}
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		if(!isset($options['mode'])){
			ParseErrorBuffer::addError('missing mode attribute',ParseErrorBuffer::$E_FATAL,$options);
		}
		if($options['mode'] != 'off' && $options['mode'] != 'wpa' && $options['mode'] != 'wpa2'){
			ParseErrorBuffer::addError('incorrect mode setting',ParseErrorBuffer::$E_FATAL,$options);
		}
		
		if(!isset($options->group_rekey_interval)){
			ParseErrorBuffer::addError('missing group_rekey_interval tag',ParseErrorBuffer::$E_FATAL,$options);
		}
		if(!isset($options->strict_rekey)){
			ParseErrorBuffer::addError('missing strict_rekey tag',ParseErrorBuffer::$E_FATAL,$options);
		}
		if(!isset($options->passphrase)){
			ParseErrorBuffer::addError('missing passphrase tag',ParseErrorBuffer::$E_FATAL,$options);
		}
		
		foreach($options->children() as $child){
			if(!in_array($child->getName(),$this->expected_tags)){
				ParseErrorBuffer::addError('Unexpected child node',ParseErrorBuffer::$E_FATAL,$child);
			}
		}
	}
}