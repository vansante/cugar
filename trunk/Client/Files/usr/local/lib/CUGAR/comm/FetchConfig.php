<?php

/**
 * 	Fetches configuration file from config server
 * 	Utilizes device's private key to send an authenticator string and
 * 	retrieves xml config if authentication succeeds
 *
 */
class FetchConfig{
	/**
	 * Directory where the private key resides
	 * 
	 * @final 
	 * @var String
	 */
	private $cert_dir = '/etc/CUGAR/';
	
	/**
	 * Private key name
	 * @var String
	 */
	private $cert_name = '';
	
	/**
	 * Address of the configuration server
	 * @var IPAddress
	 */
	private $configserver;
	
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
	
	public function encryptString($cert_name){
		$cert_name_enc = null;
        $key = file_get_contents($this->cert_dir.$cert_name);
        $result = openssl_private_encrypt($cert_name, $cert_name_encrypted, $key);
        return $result;
	}
}