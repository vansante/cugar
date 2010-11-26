<?php
class own_ip extends Statement{
	/**
	 * Constructor
	 * @param unknown_type $type
	 * @return unknown_type
	 */
	public function __construct($type){
		
	}
	
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
		
	}
}