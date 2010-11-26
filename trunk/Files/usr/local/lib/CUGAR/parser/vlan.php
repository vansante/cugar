<?php
class vlan extends Statement{
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);
		
		if($options['enable'] == 'true'){
			$this->parseChildren($options);
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		if($options['enable'] == 'true'){
			if(!isset($options->vlan_id)){
				ParseErrorBuffer::addError('vlan is enabled but no vlan_id is set',ParseErrorBuffer::$E_FATAL,$options);
			}
		}
		elseif($options['enable'] != 'false'){
			ParseErrorBuffer::addError('invalid option for vlan enable',ParseErrorBuffer::$E_FATAL,$options);
		}
		
		foreach($options->children() as $child){
			if($child->getName() != 'vlan_id'){
				ParseErrorBuffer::addError('Unexpected child node',ParseErrorBuffer::$E_FATAL,$options);
			}
		}
	}
}