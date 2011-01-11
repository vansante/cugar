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
 * 	Fetches configuration file from config server
 * 	Utilizes device's private key to send an authenticator string and
 * 	retrieves xml config if authentication succeeds
 *
 */
class FetchConfig extends Comm{
	public function __construct(){
		
	}
	
	/**
	 * fetch Configuration from the server
	 * 
	 * @throws HttpException
	 * @return String
	 */
	public function fetchConfiguration(){
		$r = new HttpRequest($this->configserver.'/getconfig/', HttpRequest::METH_POST);
		$r->addPostFields(array('cert_name' => $this->cert_name, 'cert_name_check' => $this->encryptString($this->cert_name)));
		
		return $r->send()->getBody();
	}
	
	/**
	 * Fetch the configuration from the server
	 * 
	 * @return String
	 */
	public function fetch(){
		$ch = curl_init($configserver.'/getconfig/');
		
		//return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        //	set POST values
        $data = array('cert_name' => $this->cert_name, 'cert_name_check' => $this->encryptString($this->cert_name));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        
        // $output contains the output string
        $output = curl_exec($ch);
        // close curl resource to free up system resources
        curl_close($ch);  
        return $output;
	}
}