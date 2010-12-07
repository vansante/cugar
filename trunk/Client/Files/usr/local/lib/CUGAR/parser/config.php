<?php
class config extends Statement{
	/**
	 * @return unknown_type
	 */
	public function __construct(){
		$this->expectedtags = array('ssid','hardware','updateserver');
	}

	/**
	 * (non-PHPdoc)
	 * @see Client/Files/usr/local/lib/CUGAR/parser/Statement#interpret($options)
	 */
	public function interpret($options){
		$this->validate($options);
		$ref = HostAPDConfig::getInstance();
		$ref->setApNumber(count($options->ssid));
		$this->parseChildren($options);
	}

	/**
	 * (non-PHPdoc)
	 * @see Client/Files/usr/local/lib/CUGAR/parser/Statement#validate($options)
	 */
	public function validate($options){
		$this->checkChildNodes($options);
		if(!isset($options->hardware) && count($options->hardware) != 1){
			ParseErrorBuffer::addError('no hardware options specified',ParseErrorBuffer::$E_FATAL,$options);
		}
		if(count($options->ssid) < 0 && count($options->ssid) > 8){
			if(count($options->ssid) == 0){
				ParseErrorBuffer::addError('No ssid defined',ParseErrorBuffer::$E_FATAL,$options);
			}
			if(count($options->ssid) > 8){
				ParseErrorBuffer::addError('Too many ssids defined ('.count($options->ssid).')',ParseErrorBuffer::$E_FATAL,$options);
			}
		}

	}
}