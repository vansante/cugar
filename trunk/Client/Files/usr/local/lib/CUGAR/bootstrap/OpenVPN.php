<?php
class OpenVPN{
	/**
	 * Run mode, enables or disables DEBUG flags
	 * @var Integer
	 */
	private $runmode;

	/**
	 * Configuration block for interface
	 * @var SimpleXMLElement
	 */
	private $config;

	/**
	 *
	 * @param Integer $runmode
	 * @return unknown_type
	 */
	public function __construct($runmode){
		echo "preparing OpenVPN service \n";
		$this->runmode = $runmode;
	}
}