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
class hostapd extends Statement{
	/**
	 * Constructor
	 * 
	 * @param Array $parse_opt
	 * @return void
	 */
	public function __construct($parse_opt){
		$this->parse_options = $parse_opt;
		$this->parse_options['conf_block'] = 'hostapd';
		$this->expectedtags = Array('ssid_name','mode','channel','broadcast','vlan','wpa','radius');
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
		$errorstore = ErrorStore::getInstance();
		/*
		 * Check if all expected child tags exist
		 */
		if(!isset($options->ssid_name)){
			$error = new ParseError('no ssid_name tag found',ErrorStore::$E_FATAL,$options);
			$errorstore->addError($error);
		}
		if(!isset($options->broadcast)){
			$error = new ParseError('no broadcast tag found',ErrorStore::$E_FATAL,$options);
			$errorstore->addError($error);
		}
		if(!isset($options->vlan)){
			//@TODO do we really want to explicitly throw an error on the absence of this tag? It's innconsquential
			$error = new ParseError('no vlan tag found',ErrorStore::$E_NOTICE,$options);
			$errorstore->addError($error);
		}
		if($this->parse_options['mode'] != 2 && !isset($options->wpa)){
			$error = new ParseError('no wpa tag found',ErrorStore::$E_FATAL,$options);
			$errorstore->addError($error);
		}
		
		if($this->parse_options['mode'] == 3 && !isset($options->radius)){
			$error = new ParseError('no radius tag found',ErrorStore::$E_FATAL,$options);
			$errorstore->addError($error);
		}
		elseif(isset($options->radius) && $this->parse_options['mode'] != 3){
			$error = new ParseError('radius tag found in non mode3, this tag will be skipped',ErrorStore::$E_NOTICE,$options);
			$errorstore->addError($error);
		}
		/*
		 * Check if all child tags are expected, throw error on unexpected tags
		 */
		$this->checkChildNodes($options);
	}
}