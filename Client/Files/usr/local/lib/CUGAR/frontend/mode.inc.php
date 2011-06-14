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

class Mode {
	private $config;
	
	private $buffer;
	
	/*
	 * @param Mode mode
	 * 
	 */
	public function __construct( $config, $buffer ) {
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
	 * return basic settings from the current sysconf.xml
	 */
	private function getconfig() {
		$current = $this->config->getElement('modes');
		$mode = $this->buffer->createNode('mode_selection',null,$current);

		$this->buffer->createNode('mode_selection',(string)$current->mode_selection,$mode);
		
		if( (string)$current->mode_selection == "1" ) {
			$mode1 = $this->buffer->createNode('mode1',null,$mode);
			$this->buffer->createNode('ssid_name',(string)$current->mode1->ssid_name,$mode1);
			$this->buffer->createNode('wpa_mode',(string)$current->mode1->wpa,$mode1);
			$this->buffer->createNode('passphrase',(string)$current->mode1->passphrase,$mode1);
		} elseif( (string)$current->mode_selection == "2" ) {
			//	 Infamous mode 2, it does not work.
			$mode2 = $this->buffer->createNode('mode2',null,$mode);
			$this->buffer->createNode('ssid_name',(string)$current->mode2->ssid_name,$mode2);
			$this->buffer->createNode('portal',null,$mode2);
			$this->buffer->createNode('portalmode',(string)$current->mode2->mode,$mode2);
			if((string)$current->mode2->mode == 'url'){
				$this->buffer->createNode('url',(string)$current->url);
			}
			elseif((string)$current->mode2->mode == 'local'){
				$this->buffer->createNode('files',(string)$current->files);
			}
		} elseif( (string)$current->mode_selection == "3" ) {
			$mode3 = $this->buffer->createNode('mode3',null,$mode);
			$this->buffer->createNode('server',(string)$current->mode3->server,$mode3);
		} elseif( (string)$current->mode_selection == "1_2" ) {
			$mode1 = $this->buffer->createNode('mode1',null,$mode);
			$this->buffer->createNode('ssid_name',(string)$current->mode1->ssid_name,$mode1);
			$this->buffer->createNode('wpa_mode',(string)$current->mode1->wpa,$mode1);
			$this->buffer->createNode('passphrase',(string)$current->mode1->passphrase,$mode1);
			$mode2 = $this->buffer->createNode('mode2',null,$mode);
			$this->buffer->createNode('ssid_name',(string)$current->mode2->ssid_name,$mode2);
			$this->buffer->createNode('portal',null,$mode2);
			$this->buffer->createNode('portalmode',(string)$current->mode2->mode,$mode2);
			if((string)$current->mode2->mode == 'url'){
				$this->buffer->createNode('url',(string)$current->url);
			}
			elseif((string)$current->mode2->mode == 'local'){
				$this->buffer->createNode('files',(string)$current->files);
			}
		}elseif( (string)$current->mode_selection == "1_3" ) {
			$mode1 = $this->buffer->createNode('mode1',null,$mode);
			$this->buffer->createNode('ssid_name',(string)$current->mode1->ssid_name,$mode1);
			$this->buffer->createNode('wpa_mode',(string)$current->mode1->wpa,$mode1);
			$this->buffer->createNode('passphrase',(string)$current->mode1->passphrase,$mode1);
			$mode3 = $this->buffer->createNode('mode3',null,$mode);
			$this->buffer->createNode('server',(string)$current->mode3->server,$mode3);
		}
	}
	
	/**
	 * save updated configuration received from AJAX frontend
	 */
	private function saveconfig() {
		$current = $this->config->getElement('modes');
		
		$current->mode_selection = $_POST['mode_selection_mode'];
		if( $_POST['mode_selection_mode'] == '1' ) {
			/*
			 * Basic accesspoint
			 */
			$mode1 = $current->addChild("mode1");
			$mode1->ssid_name = $_POST['mode_mode1_ssid'];
			$wpa = $mode1->addChild("wpa");
			$wpa->addAttribute('mode', $_POST['mode_mode1_encryption']);
			$wpa->passphrase = $_POST['mode_mode1_passphrase'];
		} elseif( $_POST['mode_select_mode'] == '2' ) {
			/*
			 * Captive portal
			 * @todo add whitelist support for mode 2
			 */
			$mode2 = $current->addChild("mode2");
			$mode2->ssid_name = $_POST['mode_mode2_ssid'];
			$wpa = $mode2->addChild("wpa");
			$wpa->addAttribute('mode', $_POST['mode_mode2_encryption']);
			$wpa->passphrase = $_POST['mode_mode2_passphrase'];
			$portal = $mode2->addChild("portal");
			if( $_POST['mode_mode2_portalmode'] == 'url' ){
				$portal->url = $_POST['mode_mode2_url'];
			} elseif( $_POST['mode_mode2_portalmode'] == 'local' ){
				$portal->files = $POST['mode_mode2_localfile'];
			}
			
		} elseif( $_POST['mode_select_mode'] == '3' ) {
			/*
			 * Central server
			 */
			$mode3 = $current->addChild("mode3");
			$mode3->server = $_POST['mode_mode3_server'];
			$mode3->publickey = $_POST['mode_mode3_public_key'];
			$mode3->privatekey = $_POST['mode_mode3_private_key'];
			$mode3->certificate = $_POST['mode_mode3_certificate'];
			
		} elseif( $_POST['mode_select_mode'] == '1_2' ) {
			/*
			 * Basic accesspoint & Captive portal
			 */
			/*
			 * Basic accesspoint settings 
			 */
			$mode1 = $current->addChild("mode1");
			$mode1->ssid_name = $_POST['mode_mode1_ssid'];
			$wpa = $mode1->addChild("wpa");
			$wpa->addAttribute('mode', $_POST['mode_mode1_encryption']);
			$wpa->passphrase = $_POST['mode_mode1_passphrase'];
			/*
			 * Captive portal settings
			 */
			$mode2 = $current->addChild("mode2");
			$mode2->ssid_name = $_POST['mode_mode2_ssid'];
			$wpa = $mode2->addChild("wpa");
			$wpa->addAttribute('mode', $_POST['mode_mode2_encryption']);
			$wpa->passphrase = $_POST['mode_mode2_passphrase'];
			$portal = $mode2->addChild("portal");
			if( $_POST['mode_mode2_portalmode'] == 'url' ){
				$portal->url = $_POST['mode_mode2_url'];
			} elseif( $_POST['mode_mode2_portalmode'] == 'local' ){
				$portal->files = $POST['mode_mode2_localfile'];
			}
			
		} elseif( $_POST['mode_select_mode'] == '1_3' ) {
			/*
			 * Basic accesspoint & Central server
			 */
			/*
			 * Basic accesspoint settings
			 */
			$mode1 = $current->addChild("mode1");
			$mode1->ssid_name = $_POST['mode_mode1_ssid'];
			$wpa = $mode1->addChild("wpa");
			$wpa->addAttribute('mode', $_POST['mode_mode1_encryption']);
			$wpa->passphrase = $_POST['mode_mode1_passphrase'];
			/*
			 * Central server settings
			 */
			$mode3 = $current->addChild('mode3');
			$mode3->server = $_POST['mode_mode3_server'];
			$mode3->publickey = $_POST['mode_mode3_public_key'];
			$mode3->privatekey = $_POST['mode_mode3_private_key'];
			$mode3->certificate = $_POST['mode_mode3_certificate'];
		}
		
		$this->config->saveConfig();
	}
}
?>