<?php
/**
 * Exception for Configuration errors
 */
class MalformedConfigException extends Exception{
	private $xmltag;
	private $errormsg;
	
	public function __construct($xmltag, $errormsg){
		$this->xmltag = $xmltag;
		$this->errormsg = $errormsg;	
	}
}