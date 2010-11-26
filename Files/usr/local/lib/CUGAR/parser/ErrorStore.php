<?php
/**
 * Buffer for all Parsing errors encountered during parsing.
 */
class ParseErrorBuffer{
	/**
	 * Contains all ParseError objects
	 * @var ParseError
	 */
	private $errorbuffer;
	
	/**
	 * Add error to the error buffer
	 * 
	 * @param unknown_type $error
	 * @return unknown_type
	 */
	public function addError($error){
		$errorbuffer[] = $error;
	}
}

/**
 * ParseError object to store information about individual parser errors
 */
class ParseError{
	private $message;
	private $umltrace;
	private $severity;
	
	public function __construct($message,$severity, $umltrace){
		$this->message = $message;
		$this->umltrace = $umltrace;
		$this->severity = $severity;
	}
}