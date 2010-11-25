<?php
class wpa implements Statement{
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);
		/*
		 * @TODO Missing spec for WPA / WPA 2 selection
		 * @TODO Missing spec for disabling WPA / WPA2 completely in mode1 (Desirable?)
		 * @TODO Missing something else, probably :[ 
		 */
		foreach($options->children() as $child){
			$name = $child->getName();
			if(is_class($name)){
				$tmp = new $name();
				$tmp->interpret($child);
			}
			else{
				throw new SystemError('could not find class '.$name);
			}
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		if(!isset($options->group_rekey_interval)){
			throw new MalformedConfigException($options,'missing group_rekey_interval tag');
		}
		if(!isset($options->strict_rekey)){
			throw new MalformedConfigException($options,'missing strict_rekey tag');
		}
		if(!isset($options->passphrase)){
			throw new MalformedConfigException($options,'missing passphrase tag');
		}
	}
}