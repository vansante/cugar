<?php
interface ConfigGenerator{
	public function newSSID();
	public function writeConfig();
	public function setSavePath();
}
?>