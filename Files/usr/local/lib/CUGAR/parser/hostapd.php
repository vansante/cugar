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
			throw new MalformedConfigException($options,'no ssid_name tag found');
		}
		if(!isset($options->mode)){
			throw new MalformedConfigException($options,'no mode tag found');
		}
		if(!isset($options->channel)){
			throw new MalformedConfigException($options,'no channel tag found');
		}
		if(!isset($options->broadcast)){
			throw new MalformedConfigException($options,'no broadcast tag found');
		}
		if(!isset($options->vlan)){
			//@TODO do we really want to explicitly throw an error on the absence of this tag? It's innconsquential
			throw new MalformedConfigException($options,'no vlan tag found');
		}
		if(!isset($options->wpa)){
			throw new MalformedConfigException($options,'no wpa tag found');
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
}