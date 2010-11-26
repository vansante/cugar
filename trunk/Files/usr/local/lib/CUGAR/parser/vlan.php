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
				throw new MalformedConfigException($options,'Vlan enabled but no vlan_id set');
			}
		}
		elseif($options['enable'] != 'false'){
			throw new MalformedConfigException($options,'Invalid option for vlan enable');
		}
		
		foreach($options->children() as $child){
			if($child->getName() != 'vlan_id'){
				throw new MalformedConfigException($options,'Unexpected tag encountered: '.$child->getName());
			}
		}
	}
}