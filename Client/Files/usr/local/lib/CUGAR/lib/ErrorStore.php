<?php
/*
 All rights reserved.
 Copyright (C) 2010-2011 CUGAR
 All rights reserved.

 Redistribution and use in source and binary forms, with or without
 modification, are permitted provided that the following conditions are met:

 1. Redistributions of source code must retain the above copyright notice,
 this list of conditions and the following disclaimer.

 2. Redistributions in binary form must reproduce the above copyright
 notice, this list of conditions and the following disclaimer in the
 documentation and/or other materials provided with the distribution.

 THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES,
 INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 POSSIBILITY OF SUCH DAMAGE.
 */
class ErrorStore{
	public static $E_FATAL = 0;
	public static $E_WARNING = 1;
	public static $E_NOTICE = 2;
	
	private static $ref;
	
	/**
	 * Contains all ParseError objects
	 * @var ParseError
	 */
	private $buffer_fatal;
	private $buffer_warning;
	private $buffer_notice;
	
	/**
	 * private constructor to prevent instantiation of singleton
	 * @return void
	 */
	private function __construct(){}
	
	/**
	 * Get singleton instance
	 * @return ErrorStore
	 */
	public static function getInstance(){
		if($this->ref == null){
			$this->ref = new ErrorStore();
		}
		return $this->ref;
	}
	
	/**
	 * Add error to the buffer
	 * 
	 * @param Error $error
	 * @return void
	 */
	public function addError($error){
		if($error->getSeverity() == ErrorStore::$E_FATAL){
			$this->$buffer_fatal[] = $tmp;
		}
		elseif($error->getSeverity() == ErrorStore::$E_WARNING){
			$this->$buffer_warning[] = $tmp;
		}
		elseif($error->getSeverity() == ErrorStore::$E_NOTICE){
			$this->$buffer_notice[] = $tmp;
		}
	}
	
	/**
	 * Check if errors exist of any level with greater or equal priority than $level
	 * 
	 * @param int $level
	 * @return boolean
	 */
	public function hasErrors($level){
		if($level >= ErrorStore::$E_FATAL && count(ErrorStore::$buffer_fatal) > 0){
			return true;
		}
		elseif($level >= ErrorStore::$E_WARNING && count(ErrorStore::$buffer_warning) > 0){
			return true;
		}
		elseif($level >= ErrorStore::$E_NOTICE && count(ErrorStore::$buffer_notice) > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	/**
	 * Print all the errors that occurred to stdout
	 * 
	 * currently just does a print_r until I can be bothered to create a slightly fancier function.
	 * 
	 * @param int $level
	 * @return void
	 */
	public function printErrors($level){
		if($level >= ErrorStore::$E_FATAL && count(ErrorStore::$buffer_fatal) > 0){
			print_r($this->$buffer_fatal);
		}
		elseif($level >= ErrorStore::$E_WARNING && count(ErrorStore::$buffer_warning) > 0){
			print_r($this->$buffer_warning);
		}
		elseif($level >= ErrorStore::$E_NOTICE && count(ErrorStore::$buffer_notice) > 0){
			print_r($this->$buffer_notice);
		}
	}
	
	/**
	 * return all encountered errors as string
	 * 
	 * @return String
	 */
	public function returnErrors($level){
		$buffer = null;
		
		if($level >= ErrorStore::$E_FATAL && count(ErrorStore::$buffer_fatal) > 0){
			$buffer .= print_r($this->$buffer_fatal);
		}
		elseif($level >= ErrorStore::$E_WARNING && count(ErrorStore::$buffer_warning) > 0){
			$buffer .= print_r($this->$buffer_warning);
		}
		elseif($level >= ErrorStore::$E_NOTICE && count(ErrorStore::$buffer_notice) > 0){
			$buffer .= print_r($this->$buffer_notice);
		}
	}
}

/**
 * ParseError object to store information about individual parser errors
 */
class ParseError{
	private $message;
	private $umltrace;
	private $severity;
	
	/**
	 * 
	 * @param String $message
	 * @param Int $severity
	 * @param String $umltrace
	 * @return void
	 */
	public function __construct($message,$severity, $umltrace){
		$this->message = $message;
		$this->umltrace = $umltrace;
		$this->severity = $severity;
	}
	
	/**
	 * Get the Error severity
	 * @return Int
	 */
	public function getSeverity(){
		return $this->severity;
	}
	
	/**
	 * Get the Error message
	 * @return String
	 */
	public function getMessage(){
		return $this->message;
	}
	
}

/**
 * System error object to hold System errors that occurred
 */
class SystemError extends Exception{
	private $severity;
	
	public function __construct($severity,$message,$code){
		$this->severity = $severity;
		parent::__construct($message,$code);
	}
	
	/**
	 * Get the Error severity
	 * @return Int
	 */
	public function getSeverity(){
		return $this->severity;
	}
	
	/**
	 * Get the Error message
	 * @return String
	 */
	public function getMessage(){
		return $this->message;
	}
}