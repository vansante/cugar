<?php
class portal extends Statement{
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
		if(!isset($options->local_files)){
			throw new MalformedConfigException($options,'no local tag found');
		}
		if(!isset($options->radius)){
			throw new MalformedConfigException($options,'no radius tag found');
		}
	}
}