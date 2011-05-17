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
	private $buffer;
	
	/**
	 * 
	 * @param $config
	 * @param $buffer
	 */
	public function __construct($config,$buffer){
		$this->config = $config;
		$this->buffer = $buffer;
		$this->parse();
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
		$password = $this->config->getElement('device');
		if(!empty($_POST['basic_settings_password'])){
			if($_POST['basic_settings_password'] == $_POST['basic_settings_password2']){
				$password->password = md5($_POST['basic_settings_password']);
			}
			else{
				$this->buffer->addFormError('basic_settings_password2','The new passwords are not equal');
			}
		}
		
		$current = $this->config->getElement('hardware');
		$current->hostname = $_POST['basic_settings_hostname'];
		
		if(in_array($_POST['basic_settings_wl_mode'],DEFINES::$basic_settings_wl_modes)){
			$current->mode = $_POST['basic_settings_wl_mode'];
		}
		else{
			$this->buffer->addFormError('basic_settings_wl_mode','Invalid wireless mode');
		}
		
		if($_POST['basic_settings_wl_channel'] >= 1 && $_POST['basic_settings_wl_channel'] <= 13){
			$current->channel = $_POST['basic_settings_wl_channel'];
		}
		else{
			$this->buffer->addFormError('basic_settings_wl_channel','Invalid wireless channel');
		}
		
		/*	Delete Address node and children because of the differences in child nodes for
		 *	different settings 
		 */
		$this->config->deleteElement($current->address);
		$address = $current->addChild('address');
		$address->addAttribute('type',$_POST['basic_settings_type']);
		if($_POST['basic_settings_type'] == 'static'){
			if(filter_var($_POST['basic_settings_static_ipaddr'], FILTER_VALIDATE_IP)){
				$address->addChild('ip',$_POST['basic_settings_static_ipaddr']);
			}
			else{
				$this->buffer->addFormError('basic_settings_static_ipaddr','Invalid IP address');
			}
			
			if(filter_var($_POST['basic_settings_static_subnet_mask'], FILTER_VALIDATE_IP)){
				$address->addChild('subnet_mask',$_POST['basic_settings_static_subnet_mask']);
			}
			else{
				$this->buffer->addFormError('basic_settings_static_subnet_mask','Invalid subnet mask');
			}
			
			if(filter_var($_POST['basic_settings_static_default_gateway'], FILTER_VALIDATE_IP)){
				$address->addChild('default_gateway',$_POST['basic_settings_static_default_gateway']);
			}
			else{
				$this->buffer->addFormError('basic_settings_static_default_gateway','Invalid default gateway');
			}
			
			if(filter_var($_POST['basic_settings_static_dns_server_1'], FILTER_VALIDATE_IP) && filter_var($_POST['basic_settings_static_dns_server_1'], FILTER_VALIDATE_IP)){
				$dns = $address->addChild('dns_servers');
				$dns->addChild('ip',$_POST['basic_settings_static_dns_server_1']);
				if(!empty($_POST['basic_settings_static_dns_server_2'])){
					$dns->addChild('ip',$_POST['basic_settings_static_dns_server_2']);
				}
			}
			else{
				if(filter_var($_POST['basic_settings_'], FILTER_VALIDATE_IP)){
					$this->buffer->addFormError('basic_settings_static_dns_server_1','Invalid DNS server');
				}
				if(filter_var($_POST['basic_settings_static_dns_server_2'], FILTER_VALIDATE_IP)){
					$this->buffer->addFormError('basic_settings_static_dns_server_2','Invalid DNS server');
				}
			}
		}
		
		if(!$this->buffer->hasErrors()){
			$this->config->saveConfig();
		}
	}
	
	/**
	 * return basic settings from the current sysconf.xml
	 */
	
	private function getconfig(){
		$current = $this->config->getElement('hardware');
		
		$this->buffer->createNode('hostname',(string)$current->hostname);
		$this->buffer->createNode('type',(string)$current->address['type']);
		if($current->address['type'] == 'static'){
			$static = $this->buffer->createNode('static',null);
			$this->buffer->createNode('ipaddr',(string)$current->address->ip,$static);
			$this->buffer->createNode('subnetmask',(string)$current->address->subnetmask,$static);
			$this->buffer->createNode('default_gateway',(string)$current->address->default_gateway,$static);
			$this->buffer->createNode('dns_server1',(string)$current->address->dns_servers->ip[0],$static);
			$this->buffer->createNode('dns_server2',(string)$current->address->dns_servers->ip[1],$static);
		}
		
		$hardware = $this->buffer->createNode('hardware',null);
		$this->buffer->createNode('mode',(string)$current->mode,$hardware);
		$this->buffer->createNode('channel',(string)$current->channel,$hardware);
	}
}