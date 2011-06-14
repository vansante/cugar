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
session_start();
require_once('/usr/local/lib/CUGAR/frontend/config.php');
require_once('/usr/local/lib/CUGAR/frontend/User.php');
require_once('/usr/local/lib/CUGAR/lib/Functions.php');
require_once('/usr/local/lib/CUGAR/frontend/defines.php');
require_once('/usr/local/lib/CUGAR/frontend/outputbuffer.php');

class Server{
	private $DEBUG = 0;
	private $lib_path = '/usr/local/lib/CUGAR/frontend/';
	private $config_file = '/etc/CUGAR/sysconf.xml';
	
	private $config;
	
	public function __construct(){
		$this->config = new Config($this->config_file);
		
		if($this->DEBUG == 1){
			print_r($_POST);
		}
		$user = new User($this->config);
		
		if($user->is_authenticated()){
			if($_POST['page'] == 'logout'){
				$user->logout();
			}
			else{
				$this->parseRequest();
			}
		}
		else{
			$user->authenticate();
		}
	}
	
	public function parseRequest(){
		$buffer = new outputBuffer();
		
		switch($_POST['module']){
			case 'settings':
				include($this->lib_path.'settings.inc.php');
				new settings($this->config,$buffer);
				break;
			case 'modes':
				include($this->lib_path.'mode.inc.php');
				new Mode($this->config,$buffer);
				break;			
		}
		
		$buffer->returnOutput();
	}
}

new Server();