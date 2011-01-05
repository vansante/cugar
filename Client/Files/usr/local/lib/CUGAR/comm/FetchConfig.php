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
}