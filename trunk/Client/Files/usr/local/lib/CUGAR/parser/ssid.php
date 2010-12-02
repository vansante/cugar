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
 *	Validate / interpret SSID statement
 *
 */
class ssid extends Statement{
	/**
	 * Constructor
	 *
	 * @param Array $parse_opt
	 * @return void
	 */
	public function __construct($parse_opt){
		$this->parse_options = $parse_opt;
	}

	/**
	 *
	 * @var unknown_type
	 */
	private $expectedtags = Array('hostapd','openvpn','portal','dhcp_relay');

	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret()
	 */
	public function interpret($options){
		$this->validate($options);
		
		//	Set mode for this SSID, child tags could need this for parsing.
		$this->parse_options['mode'] = (string)$options['mode'];
		$ref = HostAP::getInstance();
		$ref->setSsidMode((string)$options['mode']);
		
		$this->parseChildren($options);
	}

	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#validate()
	 */
	public function validate($options){
		if($options['mode'] >= 1 && $options['mode'] <= 3){
			if(!isset($options->hostapd)){
				ParseErrorBuffer::addError('no hostap tag found',ParseErrorBuffer::$E_FATAL,$options);
			}
				
			if($options['mode'] == 2 && !isset($options->portal)){
				ParseErrorBuffer::addError('no portal tag found',ParseErrorBuffer::$E_FATAL,$options);
			}
				
			if($options['mode'] == 3){
				if(!isset($options->openvpn)){
					ParseErrorBuffer::addError('no openvpn tag found',ParseErrorBuffer::$E_FATAL,$options);
				}
				if(!isset($options->dhcp_relay)){
					ParseErrorBuffer::addError('no dhcp_relay tag found',ParseErrorBuffer::$E_FATAL,$options);
				}
			}
				
			/*
			 * Check if all child tags are expected, throw error on unexpected tags
			 */
			foreach($options->children() as $child){
				if(!in_array($child->getName(),$this->expectedtags)){
					ParseErrorBuffer::addError('Unexpected child node encountered.',ParseErrorBuffer::$E_WARNING,$child);
				}
			}
		}
		else{
			ParseErrorBuffer::addError('invalid ssid mode '.$options['mode'],ParseErrorBuffer::$E_FATAL,$options);
		}
	}
}