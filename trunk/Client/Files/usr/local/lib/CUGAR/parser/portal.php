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
class portal extends Statement{
	/**
	 * Expected child nodes for this node
	 * @var Array
	 */
	private $expected_tags = array('local_files','radius');
	
	/**
	 * Constructor
	 *
	 * @param Array $parse_opt
	 * @return void
	 */
	public function __construct($parse_opt){
		$this->parse_options = $parse_opt;
		$this->parse_options['conf_block'] == 'portal';
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
		if(!isset($options->local_files)){
			ParseErrorBuffer::addError('no local files defined',ParseErrorBuffer::$E_FATAL,$options);
		}
		if(!isset($options->radius)){
			ParseErrorBuffer::addError('no radius options defined',ParseErrorBuffer::$E_FATAL,$options);
		}
		
		foreach($options->children() as $child){
			if(!in_array($child->getName(),$this->expected_tags)){
				ParseErrorBuffer::addError('Unexpected child node '.$child->getName(),ParseErrorBuffer::$E_FATAL,$options);
			}
		}
	}
}