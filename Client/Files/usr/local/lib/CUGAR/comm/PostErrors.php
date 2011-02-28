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
class PostErrors extends Comm{
	/**
	 * Error data to post
	 * @var String
	 */
	private $data;
	
	public function __construct(){
		
	}
	
	/**
	 * set error data to POST
	 * 
	 * @param String $data
	 * @return void
	 */
	public function setData($data){
		$this->data = $data;
	}
	
	/**
	 * post Errors to the server
	 * 
	 * @return String
	 */
	public function post(){
		if($data != null){
			$ch = curl_init($this->configserver.'/posterror/');
			
			//return the transfer as a string
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        
	        //	set POST values
	        $data = array('cert_name' => $this->cert_name, 'cert_name_check' => $this->encryptString($this->cert_name), 'time' => date('Y-m-d H:i:s'), 'description' => $this->data);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	        
	        // $output contains the output string
	        $output = curl_exec($ch);
	        // close curl resource to free up system resources
	        curl_close($ch);  
	        return true;
		}
		else{
			return false;
		}
	}
}
?>