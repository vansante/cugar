<?php
class hardware extends Statement{
	
	/**
	 * Constructor
	 * @return void
	 */
	public function __construct(){
		$this->expectedtags = array('mode','channel','hostname','address');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Client/Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);
		$this->parseChildren($options);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Client/Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		if(!isset($options->mode)){
			ParseErrorBuffer::addError('no hardware mode defined',ParseErrorBuffer::$E_FATAL,$options);
		}
		if(!isset($options->channel)){
			ParseErrorBuffer::addError('no channel defined',ParseErrorBuffer::$E_FATAL,$options);
		}
		
		$this->checkChildNodes($options);
	}
}