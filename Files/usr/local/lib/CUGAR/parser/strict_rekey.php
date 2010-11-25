<?php
class strict_rekey implements Statement{
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);
		
		$inst = HostAP::getInstance();
		$inst->setWpaStrictRekey((string)$options);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		if($options != 'true' && $options != 'false'){
			throw new MalformedConfigException($options,'Invalid strict_rekey option, expected: (true | false)');
		}
	}
}
?>