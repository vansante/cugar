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
class openvpn extends Statement{
	/**
	 * Constructor
	 * @param Array $opt
	 * @return unknown_type
	 */
	public function __construct($opt){
		$this->parse_options = $opt;
		$this->parse_options['conf_block'] = 'openvpn';
		$this->expectedtags = array('tunnel','certificates');
	}
	
	public function interpret($options){
		$this->validate($options);
		$this->parseChildren($options);
		
		$ref = OpenVPNConfig::getInstance();
	}
	
	public function validate($options){
		$errorstore = ErrorStore::getInstance();
		if(!isset($options->tunnel)){
			$error = new ParseError('no tunnel definitions found',ErrorStore::$E_FATAL,$options);
			$errorstore->addError($error);
		}
		if(count($options->tunnel) > 2){
			$error = new ParseError('too many tunnels defined',ErrorStore::$E_FATAL,$options);
			$errorstore->addError($error);
		}
		if(!isset($options->certificates)){
			$error = new ParseError('no certificates tag found',ErrorStore::$E_FATAL,$options);
			$errorstore->addError($error);
		}
		$this->checkChildNodes($options);
	}
	
}