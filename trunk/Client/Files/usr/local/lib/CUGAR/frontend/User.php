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
class User{
	/**
	 * Configuration Object
	 * @var Config
	 */
	private $config;

	/**
	 *
	 */
	public function __construct($config){
		session_start();
		$this->config = $config;
	}

	/**
	 * Check if user is authenticated
	 * @return boolean
	 */
	public function is_authenticated(){
		if(isset($_SESSION['uid']) && $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']){
			return true;
		}
		else{
			return false;
		}
	}

	/**
	 * Check user authentication
	 * @return boolean
	 */
	public function authenticate(){
		if(isset($_POST['password'])){
			$pass = md5($_POST['password']);
			$device_settings = $this->config->getElement('device');
			if((string)$device_settings->password == $pass){
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['uid'] = 1000;
				echo '<reply action="login-ok" />';
			}
			else{
				echo '<reply action="login-error"><message type="error">Invalid password</message></reply>';
			}
		}
		else{
			echo '<reply action="login-error"><message type="error">Login required.</message></reply>';
		}
	}

	/**
	 * Destroy the users session
	 */
	public function logout(){
		$_SESSION['ip'] = '';
		$_SESSION['username'] = '';
		$_SESSION['uid'] = '';
		session_destroy();
	}
}