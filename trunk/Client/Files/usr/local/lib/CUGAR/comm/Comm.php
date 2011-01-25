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
class Comm{
	/**
	 * Directory where the private key resides
	 * 
	 * @final 
	 * @var String
	 */
	protected $cert_dir = '/etc/CUGAR/';
	
	/**
	 * Private key name
	 * @var String
	 */
	protected $cert_name = '';
	
	/**
	 * Address of the configuration server
	 * @var IPAddress
	 */
	protected $configserver;
	
	/**
	 * Set the server to fetch the configuration from
	 * 
	 * @param IP $server
	 * @return void
	 */
	public function setConfigServer($server){
		$this->configserver = $server;
	}
	
	/**
	 * Set certificate name
	 * 
	 * @param String $certname
	 * @return void
	 */
	public function setCertName($certname){
		$this->cert_name = $certname;
	}
	
	/**
	 * Encrypt test string
	 * @param String $cert_name
	 * @return void
	 */
	protected function encryptString($cert_name){
		$cert_name_enc = null;
        $key = file_get_contents($this->cert_dir.$cert_name);
        $result = openssl_private_encrypt($cert_name, $cert_name_encrypted, $key);
        return $cert_name_encrypted;
	}
}