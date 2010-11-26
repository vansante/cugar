<?php
class portal extends Statement{
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
		if(!isset($options->local_files)){
			ParseErrorBuffer::addError('no local files defined',ParseErrorBuffer::$E_FATAL,$options);
		}
		if(!isset($options->radius)){
			ParseErrorBuffer::addError('no radius options defined',ParseErrorBuffer::$E_FATAL,$options);
		}
	}
}