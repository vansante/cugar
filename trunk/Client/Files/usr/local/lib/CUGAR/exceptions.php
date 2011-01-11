<?php
/**
 * Exception for Configuration errors
 */
class MalformedConfigException extends Exception{
	private $xmltag;
	
	public function __construct($xmltag, $errormsg){
		$this->xmltag = $xmltag;
		$this->message = $errormsg;	
	}
}