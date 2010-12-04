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
class tunnel extends Statement{
	/**
	 * Constructor
	 * @param Array $opt
	 * @return unknown_type
	 */
	public function __construct($opt){
		$this->parse_options = $opt;
		$this->expectedtags = array('server','port','cipher','compression');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);
		
		$ref = OpenVPNConfig::getInstance();
		$ref->newTunnel();
		$ref->setTunnelType((string)$options['type']);
		$this->parseChildren($options);
		$ref->endTunnel();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		if(!isset($options->server)){
			ParseErrorBuffer::addError('no server tag found',ParseErrorBuffer::$E_FATAL,$options);
		}
		if(!isset($options->port)){
			ParseErrorBuffer::addError('no port tag found',ParseErrorBuffer::$E_FATAL,$options);
		}
		if(!isset($options->cipher)){
			ParseErrorBuffer::addError('no cipher tag found',ParseErrorBuffer::$E_FATAL,$options);
		}
		if(!isset($options->compression)){
			ParseErrorBuffer::addError('no compression tag found',ParseErrorBuffer::$E_FATAL,$options);
		}
		
		$this->checkChildNodes($options);
	}
}