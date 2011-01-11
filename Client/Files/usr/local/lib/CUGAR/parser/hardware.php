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
		$ref = System::getInstance();
		$ref->startSystem();
		
		$this->validate($options);
		$this->parseChildren($options);
	
		$ref->endSystem();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Client/Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		$errorstore = ErrorStore::getInstance();
		if(!isset($options->mode)){
			$error = new ParseError('no hardware mode defined',ErrorStore::$E_FATAL,$options);
			$errorstore->addError($error);
		}
		if(!isset($options->channel)){
			$error = new ParseError('no channel defined',ErrorStore::$E_FATAL,$options);
			$errorstore->addError($error);
		}
		
		$this->checkChildNodes($options);
	}
}