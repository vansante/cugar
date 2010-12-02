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
	 * Expected child nodes for this node
	 * 
	 * @var Array
	 */
	private $expectedtags = Array('ssid_name','mode','channel','broadcast','vlan','wpa','radius');

	/**
	 * Constructor
	 * 
	 * @param Array $parse_opt
	 * @return void
	 */
	public function __construct($parse_opt){
		$this->parse_options = $parse_opt;
		$this->parse_options['conf_block'] == 'hostapd';
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
		/*
		 * Check if all expected child tags exist
		 */
		if(!isset($options->ssid_name)){
			ParseErrorBuffer::addError('no ssid_name tag found',ParseErrorBuffer::$E_FATAL,$options);
		}
		if(!isset($options->broadcast)){
			ParseErrorBuffer::addError('no broadcast tag found',ParseErrorBuffer::$E_FATAL,$options);
		}
		if(!isset($options->vlan)){
			//@TODO do we really want to explicitly throw an error on the absence of this tag? It's innconsquential
			ParseErrorBuffer::addError('no vlan tag found',ParseErrorBuffer::$E_NOTICE,$options);
		}
		if($this->parse_options['mode'] != 2 && !isset($options->wpa)){
			ParseErrorBuffer::addError('no wpa tag found',ParseErrorBuffer::$E_FATAL,$options);
		}
		
		if($this->parse_options['mode'] == 3 && !isset($options->radius)){
			ParseErrorBuffer::addError('no radius tag found',ParseErrorBuffer::$E_FATAL,$options);
		}
		elseif(isset($options->radius)){
			ParseErrorBuffer::addError('radius tag found in non-mode 3, this tag will be skipped',ParseErrorBuffer::$E_NOTICE,$options);
		}
		/*
		 * Check if all child tags are expected, throw error on unexpected tags
		 */
		foreach($options->children() as $child){
			if(!in_array($child->getName(),$this->expectedtags)){
				ParseErrorBuffer::addError('Unexpected child node '.$child->getName(),ParseErrorBuffer::$E_FATAL,$child);
			}
		}
	}
}