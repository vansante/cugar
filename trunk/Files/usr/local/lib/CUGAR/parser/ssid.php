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
class ssid implements Statement{
	private $expectedtags = Array('hostapd','openvpn','portal','dhcp_relay');
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret()
	 */
	public function interpret($options){
		validate($options);
		
		foreach($options->children() as $child){
			//	Interpret each child tag, and we're through (because SSID contains no system configuration and is merely a container)
			$name = $child->getName();
			$tmp = new $name();
			$tmp->interpret($child);
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#validate()
	 */
	public function validate($options){
		if($options['mode'] >= 1 && $options['mode'] <= 3){
			if(!isset($options->hostapd)){
				throw new MalformedConfigException($options,'no hostap tag found');
			}
			
			if($options['mode'] == 2 && !isset($options->portal)){
				throw new MalformedConfigException($options,'no portal tag found for mode 2 config');
			}
			
			if($options['mode'] == 3){
				if(!isset($options->openvpn)){
					throw new MalformedConfigException($options, 'no openvpn tag found for mode 3 config');
				}
				if(!isset($options->dhcp_relay)){
					throw new MalformedConfigException($options, 'no dhcp_relay tag found for mode 3 config');
				}
			}
			
			/*
			 * Check if all child tags are expected, throw error on unexpected tags
			 */
			foreach($options->children() as $child){
				if(!in_array($child->getName(),$this->expectedtags)){
					throw new MalformedConfigException($child,'unexpected tag');
				}
			}
		}
		else{
			throw new MalformedConfigException($options,'invalid mode - ' + $options['mode']);
		}
	}
}