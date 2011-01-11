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
class wpa extends Statement{

	/**
	 * Constructor
	 *
	 * @param Array $parse_opt
	 * @return void
	 */
	public function __construct($parse_opt){
		$this->parse_options = $parse_opt;
		$this->expectedtags = array('passphrase','strict_rekey','group_rekey_interval');
	}

	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);

		$inst = HostAPDConfig::getInstance();
		if($this->parse_options['mode'] == 1){
			$inst->setWpaMode($options['mode']);
		}

		$this->parseChildren($options);
	}

	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		$errorstore = ErrorStore::getInstance();
		if($this->parse_options['mode'] == 1 && !isset($options['mode'])){
			$error = new ParseError('missing mode attribute',ErrorStore::$E_FATAL,$options);
			$errorstore->addError($error);
		}
		if($this->parse_options['mode'] == 1 && ($options['mode'] != 'off' && $options['mode'] != 'wpa' && $options['mode'] != 'wpa2')){
			$error = new ParseError('incorrect mode setting',ErrorStore::$E_FATAL,$options);
			$errorstore->addError($error);
		}

		if($this->parse_options['mode'] == 1){
			if($options['mode'] != 'off'){
				if(!isset($options->group_rekey_interval)){
					$error = new ParseError('missing group_rekey_interval tag',ErrorStore::$E_FATAL,$options);
					$errorstore->addError($error);
				}
				if(!isset($options->strict_rekey)){
					$error = new ParseError('missing strict_rekey tag',ErrorStore::$E_FATAL,$options);
					$errorstore->addError($error);
				}
				if(!isset($options->passphrase)){
					$error = new ParseError('missing passphrase tag',ErrorStore::$E_FATAL,$options);
					$errorstore->addError($error);
				}
			}
			else{
				if(isset($options->group_rekey_interval)){
					$error = new ParseError('group_rekey_interval tag present, but wpa is switched off',ErrorStore::$E_NOTICE,$options);
					$errorstore->addError($error);
				}
				if(isset($options->strict_rekey)){
					$error = new ParseError('strict_rekey tag present, but wpa is switched off',ErrorStore::$E_NOTICE,$options);
					$errorstore->addError($error);
				}
				if(isset($options->passphrase)){
					$error = new ParseError('passphrase tag present, but wpa is switched off',ErrorStore::$E_NOTICE,$options);
					$errorstore->addError($error);
				}
			}
		}
		elseif($this->parse_options['mode'] == 3){
			if(!isset($options->group_rekey_interval)){
				$error = new ParseError('missing group_rekey_interval tag',ErrorStore::$E_FATAL,$options);
				$errorstore->addError($error);
			}
			if(!isset($options->strict_rekey)){
				$error = new ParseError('missing strict_rekey tag',ErrorStore::$E_FATAL,$options);
				$errorstore->addError($error);
			}
		}

		$this->checkChildNodes($options);
	}
}