<?php
class config extends Statement{
	/**
	 * @return unknown_type
	 */
	public function __construct(){
		$this->expectedtags = array('ssid','hardware','update_server');
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
		$errorstore = ErrorStore::getInstance();
		$this->checkChildNodes($options);
		if(!isset($options->hardware) && count($options->hardware) != 1){
			$error = new ParseError('no hardware options specified',ErrorStore::$E_FATAL,$options);
			$errorstore->addError($error);
		}
		if(count($options->ssid) < 0 && count($options->ssid) > 8){
			if(count($options->ssid) == 0){
				$error = new ParseError('No ssid defined',ErrorStore::$E_FATAL,$options);
				$errorstore->addError($error);
			}
			if(count($options->ssid) > 8){
				$error = new ParseError('Too many ssids defined ('.count($options->ssid).')',ErrorStore::$E_FATAL,$options);
				$errorstore->addError($error);
			}
		}

	}
}