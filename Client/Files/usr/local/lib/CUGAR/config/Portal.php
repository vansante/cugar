<?php
/*
 All rights reserved.
 Copyright (C) 2010-2011 CUGAR
 All rights reserved.

 Redistribution and use in source and binary forms, with or without
 modification, are permitted provided that the following conditions are met:

 1. Redistributions of source code must retain the above copyright notice,
 this list of conditions and the following disclaimer.

 2. Redistributions in binary form must reproduce the above copyright
 notice, this list of conditions and the following disclaimer in the
 documentation and/or other materials provided with the distribution.

 THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES,
 INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * Captive portal configuration manager
 *
 * 
 */
class PortalConfig implements ConfigGenerator{
	private static $self;
	
	private $buffer;
	private $FILEPATH = "/usr/local/etc/chilli";
	private $FILENAME = "chillispot.conf";
	
	private $HTML_FILEPATH = "/var/www";
	
	/**
	 * The remote file that contains the captive portal HTML 
	 * @var String
	 */
	private $remote_file = null;
	
	/**
	 * Get singleton instance
	 * @static
	 * @return PortalConfig
	 */
	public static function getInstance(){
		if(PortalConfig::$self == null){
			PortalConfig::$self = new PortalConfig();
		}
		return PortalConfig::$self; 
	}
	
	/**
	 * Private constructor because this is a singleton.
	 * @return unknown_type
	 */
	private function __construct(){
		if(!is_dir($this->HTML_FILEPATH)){
			mkdir($this->HTML_FILEPATH);
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/config/ConfigGenerator#setSavePath()
	 */
	public function setSavePath($filepath){
		$this->FILEPATH = $filepath;
	}
	
	public function setRemoteFile($remoteFile){
		$this->remote_file = $remoteFile;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Files/usr/local/lib/CUGAR/config/ConfigGenerator#writeConfig()
	 */
	public function writeConfig(){
		//		Fetch remote file!
		
		//		
		
		$fp = fopen($this->FILEPATH,'w');
		if($fp){
			fwrite($fp,$this->buffer);
			fclose($fp);
		}
	}
}