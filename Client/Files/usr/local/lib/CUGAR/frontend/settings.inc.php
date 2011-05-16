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
class settings{
	private $config;
	
	/**
	 * 
	 * 
	 * @param Config $config
	 */
	public function __construct($config){
		$this->config = $config;
	}
	
	/**
	 * Handle request made by AJAX frontend
	 */
	public function parse(){
		if($_POST['page'] == 'get'){
			$this->getconfig();
		}
		if($_POST['page'] == 'save'){
			$this->saveconfig();
		}
	}
	
	/**
	 * save updated configuration received from AJAX frontend
	 */
	private function saveconfig(){
		$current = $this->config->getElement('hardware');
		$current->hostname = $_POST['basic_settings_hostname'];
		$current->mode = $_POST['basic_settings_wl_mode'];
		$current->channel = $_POST['basic_settings_wl_channel'];
		
		/*	Delete Address node and children because of the differences in child nodes for
		 *	different settings 
		 */
		$this->config->deleteElement($current->address);
		$address = $current->addChild('address');
		$address->addAttribute('type',$_POST['basic_settings_type']);
		if($_POST['basic_settings_type'] == 'static'){
			$address->addChild('ip',$_POST['basic_settings_static_ipaddr']);
			$address->addChild('subnet_mask',$_POST['basic_settings_static_subnet_mask']);
			$address->addChild('default_gateway',$_POST['basic_settings_static_default_gateway']);
			
			$dns = $address->addChild('dns_servers');
			$dns->addChild('ip',$_POST['basic_settings_static_dns_server_1']);
			if(!empty($_POST['basic_settings_static_dns_server_2'])){
				$dns->addChild('ip',$_POST['basic_settings_static_dns_server_2']);
			}
		}
		
		$this->config->saveConfig();
	}
	
	/**
	 * return basic settings from the current sysconf.xml
	 */
	private function getconfig(){
		$current = $this->config->getElement('hardware');
		echo '<reply action="ok"><basic_settings>';
		echo '<hostname>'.(string)$current->hostname.'</hostname>';
		echo '<type>'.(string)$current->address['type'].'</type>';
		if($current->address['type'] == 'static'){
			echo '<static>';
			echo '<ipaddr>'.(string)$current->address->ip.'</ipaddr>';
			echo '<subnetmask>'.(string)$current->address->subnetmask.'</subnmetmask>';
			echo '<default_gateway>'.$current->address->default_gateway.'</default_gateway>';
			echo '<dns_server1>'.(string)$current->address->dns_servers->ip[0].'</dns_server1>';
			if(isset($current->address->dns_servers->ip[1])){
				echo '<dns_server2>'.(string)$current->address->dns_servers->ip[1].'</dns_server2>';
			}
			echo '</static>';
		}
		echo '<hardware>';
		echo '<mode>'.(string)$current->mode.'</mode>';
		echo '<channel>'.(string)$current->channel.'</channel>';
		echo '</hardware>';
		echo '</basic_settings></reply>';
	}
}