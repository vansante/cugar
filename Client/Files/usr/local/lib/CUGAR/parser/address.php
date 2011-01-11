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
class address extends Statement{
	
	public function __construct($parse_opt){
		$this->parse_options = $parse_opt;
		$this->parse_options['conf_block'] = 'address';
	}
	
	public function interpret($options){
		$this->validate($options);
		$ref = System::getInstance();
		$ref->setAddressType($options['type']);
		$this->parseChildren($options);
	}
	
	public function validate($options){
		$errorstore = ErrorStore::getInstance();
		if($options['type'] == 'static'){
			$this->expectedtags = array('ip','subnet_mask','default_gateway','dns_servers');
			if(!isset($options->ip)){
				$error = new ParseError('No IP address tag found',ErrorStore::$E_FATAL,$options);
				$errorstore->addError($error);
			}
			if(!isset($options->subnet_mask)){
				$error = new ParseError('No subnet_mask tag found',ErrorStore::$E_FATAL,$options);
				$errorstore->addError($error);
			}
			if(!isset($options->default_gateway)){
				$error = new ParseError('no default_gateway tag found',ErrorStore::$E_FATAL,$options);
				$errorstore->addError($error);
			}
			if(!isset($options->dns_servers)){
				$error = new ParseError('no dns_servers tag found',ErrorStore::$E_FATAL,$options);
				$errorstore->addError($error);
			}
		}
		elseif($options['type'] == 'dhcp'){
			$this->expectedtags = array('');
		}
		else{
			$error = new ParseError('Invalid address type specified',ErrorStore::$E_FATAL,$options);
			$errorstore->addError($error);
		}
		$this->checkChildNodes($options);
	}
}