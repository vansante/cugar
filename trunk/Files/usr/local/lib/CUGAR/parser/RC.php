<?php
/**
 * RC class
 * 
 * Manages rc.conf contents, other configuration classes will insert their rc.conf lines
 * through this class to maintain consistency.
 *
 */
class RC{
	private $buffer;
	private $FILEPATH = "/etc/rc.conf";
	
	/**
	 * Write out file to filepath
	 */
	public function saveFile(){
		$fp = fopen($this->FILEPATH,'w');
		if($fp){
			fwrite($fp,$this->buffer);
		}
	}
}