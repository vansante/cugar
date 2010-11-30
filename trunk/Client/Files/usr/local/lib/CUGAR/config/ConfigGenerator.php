<?php
interface ConfigGenerator{
	/**
	 * Start configuration management for a new virtualSSID on the device
	 * @return unknown_type
	 */
	public function newSSID();
	
	/**
	 * Write config out to file
	 * @return unknown_type
	 */
	public function writeConfig();
	
	/**
	 * set directory to save config file in (used primarily for debugging)
	 * 
	 * @param $path String
	 * @return unknown_type
	 */
	public function setSavePath($path);
}
?>