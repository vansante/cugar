<?php
class hostapd implements Statement{
	private $expectedtags = Array('ssid_name','mode','channel','broadcast','vlan','wpa');

	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);

		//	Interpret each child tag, and we're through (because this tag is merely a container)
		foreach($options->children() as $child){
			$name = $child->getName();
			if(class_exists($name)){
				$tmp = new $name();
				$tmp->interpret($child);
			}
			else{
				throw new SystemError('Could not find class '.$name);
			}
		}
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