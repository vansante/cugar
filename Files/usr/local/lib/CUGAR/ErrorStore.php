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
	private static $buffer_fatal;
	private static $buffer_warning;
	private static $buffer_notice;
	
	/**
	 * Add error to the error buffer
	 * 
	 * @param unknown_type $error
	 * @return void
	 */
	public static function addError($message,$severity,$umltrace){
		$tmp = new ParseError($message,$severity, $umltrace);
		if($severity == ParseErrorBuffer::$E_FATAL){
			ParseErrorBuffer::$buffer_fatal[] = $tmp;
		}
		if($severity == ParseErrorBuffer::$E_WARNING){
			ParseErrorBuffer::$buffer_warning[] = $tmp;
		}
		if($severity == ParseErrorBuffer::$E_NOTICE){
			ParseErrorBuffer::$buffer_notice[] = $tmp;
		}
	}
	
	/**
	 * Check if errors exist of any level with greater or equal priority than $level
	 * 
	 * @param int $level
	 * @return boolean
	 */
	public static function hasErrors($level){
		if($level >= ParseErrorBuffer::$E_FATAL && count(ParseErrorBuffer::$buffer_fatal) > 0){
			return true;
		}
		elseif($level >= ParseErrorBuffer::$E_WARNING && count(ParseErrorBuffer::$buffer_warning) > 0){
			return true;
		}
		elseif($level >= ParseErrorBuffer::$E_NOTICE && count(ParseErrorBuffer::$buffer_notice) > 0){
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
	public static function printErrors($level){
		if($level >= ParseErrorBuffer::$E_FATAL && count(ParseErrorBuffer::$buffer_fatal) > 0){
			print_r(ParseErrorBuffer::$buffer_fatal);
		}
		elseif($level >= ParseErrorBuffer::$E_WARNING && count(ParseErrorBuffer::$buffer_warning) > 0){
			print_r(ParseErrorBuffer::$buffer_warning);
		}
		elseif($level >= ParseErrorBuffer::$E_NOTICE && count(ParseErrorBuffer::$buffer_notice) > 0){
			print_r(ParseErrorBuffer::$buffer_notice);
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
	
	public function __construct($message,$severity, $umltrace){
		$this->message = $message;
		$this->umltrace = $umltrace;
		$this->severity = $severity;
	}
}