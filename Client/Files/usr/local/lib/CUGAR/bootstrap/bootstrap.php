<?php
/**
 * Bootstrap class
 * Activates at boot to fetch the configuration and
 * to do some base configuration required for the fetching of the configuration
 */
class BootStrap{

	/**
	 * Base XML config
	 *
	 * Configuration of system settings that are to be injected into
	 * the server side config XML if mode 3 is enabled
	 *
	 * @var SimpleXMLElement
	 */
	private $config;
	
	/**
	 * Server-side XML configuration
	 * 
	 * Configuration fetched from the server, local configuration will
	 * be merged into this if a server configuration exists.
	 * 
	 * @var SimpleXMLElement
	 */
	private $serverConfig;

	/**
	 * Filename of the base system config file
	 * @var String
	 */
	private $filename = 'sysconf.xml';

	/**
	 * Filepath to the base system config file
	 * @var String
	 */
	private $filepath = '/etc/CUGAR/';

	public function __construct(){
		try{
			$this->readBaseXML();
			$this->prepSystem();
		}
		catch(Exception $e){
			print_r($e);
		}
	}

	/**
	 * Prep the system for configuration
	 * @return void
	 * @throws Exception
	 */
	public function prepSystem(){
		if($this->config->modes->mode_selection == '3' || $this->config->modes->mode_selection == '1_3' || $this->config->modes->mode_selection == '2_3'){
			//	Mode 3, fetch server-side config
			$fetch = new FetchConfig();
			$fetch->setConfigServer((string)$this->config->modes->mode3->server);
			$fetch->setCertName((string)$this->config->modes->mode3->private_key);
			
			$this->serverConfig = $fetch->fetch();
			
			if(strlen($this->serverConfig) > 1){
				if($this->config->modes->mode_selection == '1_3' || $this->config->modes->mode_selection == '2_3'){
					$this->mergeConfiguration();		
				}
				
				$this->writeConfig();
			}
		}
	}
	
	/**
	 * Save merged configuration file to disk
	 * 
	 * @return void
	 */
	private function writeConfig(){
		$fp = fopen($filepath.'config.xml',w);
		if($fp){
			fwrite($fp,$this->serverConfig);
			fclose($fp);
		}
		else{
			throw new Exception('Could not open file for writing');
		}
	}
	
	/**
	 * Merge local configuration with the server-side configuration
	 * 
	 * @return void
	 */
	private function mergeConfiguration(){
		$this->serverConfig = simplexml_load_string($this->serverConfig);
		
		$this->serverConfig->hardware->addChild('hostname',$this->config->hardware->hostname);
		$address = $this->serverConfig->hardware->addChild('address');
		$address->addAttribute('type',$this->config->hardware->address['type']);
		$address->addChild('subnet_mask',$this->config->hardware->address->subnet_mask);
		$address->addChild('ip',$this->config->hardware->address->ip);
		$address->addChild('default_gateway',$this->config->hardware->address->default_gateway);
		$dns = $address->addChild('dns_servers');
		
		foreach($this->config->hardware->address->dns_servers->ip as $ip){
			$dns->addChild('ip',(string)$ip);
		}
		
		if(isset($this->config->modes->mode1)){
			$tag = $this->serverConfig->addChild('ssid');
			$tag->addAttribute('mode','1');
			$hostapd = $tag->addChild('hostapd');
			
			$hostapd->addChild('ssid_name',$this->config->modes->mode1->ssid_name);
			$hostapd->addChild('broadcast','true');
			
			$wpa = $hostapd->addChild('wpa');
			$wpa->addAttribute('mode',$this->config->modes->mode1->wpa['mode']);
			$wpa->addChild('passphrase',$this->config->modes->mode1->wpa->passphrase);
			$wpa->addChild('strict_rekey','true');
			$wpa->addChild('group_rekey_interval','800');
		}
		if(isset($this->config->modes->mode2)){
			$tag = $this->serverConfig->addChild('ssid');
			$tag->addAttribute('mode','2');
			$hostapd = $tag->addChild('hostapd');
			
			$hostapd->addChild('ssid_name',$this->config->modes->mode1->ssid_name);
			$hostapd->addChild('broadcast','true');
		}
	}
	
	/**
	 * Fetch the base XML from file
	 * @return void
	 * @throws Exception
	 */
	public function readBaseXML(){
		if(file_exists($this->filepath.$this->filename)){
			//	Use custom error throwing for libxml
			$previouslibxmlSetting = libxml_use_internal_errors(true);

			$this->config = simplexml_load_file($this->filepath.$this->filename);

			//Failed loading the XML, throw excption.
			if (!$this->config){
				$message = "Failed to load configuration file {$file}. Invalid XML. ";
				foreach(libxml_get_errors() as $error) {
					$message .= $error->message;
				}

				libxml_clear_errors();
				throw new Exception($message);
			}

			//Set back to default error handling
			libxml_use_internal_errors($previouslibxmlSetting);
		}
		else{
			throw new Exception('XML file does not exist');
		}
	}
}