<?php
class file extends Statement{
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		//@TODO Write out the file (use a buffer like the other configs?)
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		if(empty($options['name'])){
			ParseErrorBuffer::addError('no filename specified',ParseErrorBuffer::$E_FATAL,$options);
		}
		
		if(empty($options)){
			ParseErrorBuffer::addError('empty file specified',ParseErrorBuffer::$E_FATAL,$options);
		}
	}
}