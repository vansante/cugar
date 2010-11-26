<?php
class wpa extends Statement{
	/**
	 * Expected child nodes for this statement
	 * @var Array
	 */
	private $expected_tags = array('passphrase','strict_rekey','group_rekey_interval');
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);
		
		$inst = HostAP::getInstance();
		$inst->setWpaMode($options['mode']);
		
		foreach($options->children() as $child){
			$name = $child->getName();
			if(class_exists($name)){
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
		if(!isset($options['mode'])){
			throw new MalformedConfigException($options,'missing mode attribute in wpa tag');
		}
		if($options['mode'] != 'off' && $options['mode'] != 'wpa' && $options['mode'] != 'wpa2'){
			throw new MalformedConfigException($options,'incorrect setting for wpa mode');
		}
		
		if(!isset($options->group_rekey_interval)){
			throw new MalformedConfigException($options,'missing group_rekey_interval tag');
		}
		if(!isset($options->strict_rekey)){
			throw new MalformedConfigException($options,'missing strict_rekey tag');
		}
		if(!isset($options->passphrase)){
			throw new MalformedConfigException($options,'missing passphrase tag');
		}
		
		foreach($options->children() as $child){
			if(!in_array($child->getName(),$this->expected_tags)){
				throw new MalformedConfigException($options,'unexpected tag encountered: '.$child->getName());
			}
		}
	}
}