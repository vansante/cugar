<?php
class radius extends Statement{
	/**
	 * Expected child nodes for this statement
	 * @var Array
	 */
	private $expected_tags = array('own_ip','nas_identifier','auth_server','acct_server');
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);
		$this->parseChildren($options);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		if(!isset($options->own_ip)){
			ParseErrorBuffer::addError('no own_ip tag found',ParseErrorBuffer::$E_FATAL,$options);
		}
		if(!isset($options->acct_server)){
			ParseErrorBuffer::addError('no acct_server tag found',ParseErrorBuffer::$E_FATAL,$options);
		}
		if(!isset($options->auth_server)){
			ParseErrorBuffer::addError('no auth_server tag found',ParseErrorBuffer::$E_FATAL,$options);
		}
		if(!isset($options->nas_identifier)){
			ParseErrorBuffer::addError('no nas_identifier tag found',ParseErrorBuffer::$E_FATAL,$options);
		}
		
		foreach($options->children() as $child){
			if(!in_array($child->getName(),$this->expected_tags)){
				ParseErrorBuffer::addError('Unexpected child node',ParseErrorBuffer::$E_FATAL,$child);
			}
		}
	}
}