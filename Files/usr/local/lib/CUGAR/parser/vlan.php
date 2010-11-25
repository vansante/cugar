<?php
class vlan implements Statement{
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);
		
		if($options['enable'] == 'true'){
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
	}
}