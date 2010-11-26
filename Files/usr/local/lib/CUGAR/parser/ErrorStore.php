<?php
/**
 * Buffer for all Parsing errors encountered during parsing.
 */
class ParseErrorBuffer{
	public static $E_FATAL = 0;
	public static $E_WARNING = 1;
	public static $E_NOTICE = 2;
	/**
	 * Contains all ParseError objects
	 * @var ParseError
	 */
	private static $errorbuffer;
	
	/**
	 * Add error to the error buffer
	 * 
	 * @param unknown_type $error
	 * @return void
	 */
	public static function addError($message,$severity,$umltrace){
		ParseErrorBuffer::$errorbuffer[] = new ParseError($message,$severity, $umltrace);
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