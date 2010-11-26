<?php
class hostapd extends Statement{
	private $expectedtags = Array('ssid_name','mode','channel','broadcast','vlan','wpa');

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
		if(!isset($options->wpa)){
			ParseErrorBuffer::addError('no wpa tag found',ParseErrorBuffer::$E_FATAL,$options);
		}

		/*
		 * Check if all child tags are expected, throw error on unexpected tags
		 */
		foreach($options->children() as $child){
			if(!in_array($child->getName(),$this->expectedtags)){
				ParseErrorBuffer::addError('Unexpected child node',ParseErrorBuffer::$E_FATAL,$child);
			}
		}
	}
}