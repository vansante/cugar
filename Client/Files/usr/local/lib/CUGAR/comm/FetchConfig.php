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
	final private $cert_dir = '/etc/CUGAR/';
	
	/**
	 * Address of the configuration server
	 * @var IPAddress
	 */
	private $configserver;
	
	public function __construct(){
		
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
	
	public function fetch(){
		$r = new HttpRequest($configserver, HttpRequest::METH_POST);
		$r->setOptions(array('cookies' => array('lang' => 'de')));
		$r->addPostFields(array('cert_name' => $certname, 'cert_name_check' => $enc_certname));
	}
	
	public function encryptString($cert_name){
        $key = file_get_contents($this->cert_dir.$cert_name.'.key');
        $cert_name_decrypted = false;
        $result = openssl_public_encrypt($cert_name_enc, $cert_name_decrypted, $key);
        return $result;
	}
	
	/**
	 * Fetch the certificate name from the filesystem
	 * 
	 * @return unknown_type
	 */
	public function getCertName(){
		$cert_name = shell_exec('ls '.$this->cert_dir.' | grep .key');
		$cert_name = str_replace('.key','',$cert_name);
		return $cert_name;
	}
}