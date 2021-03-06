<?php

class XMLConfig {

    const VERSION = 0.1;

    protected $device, $config;

    protected $doc;
    
    public function  __construct($device) {
        if (!$device instanceof Device) {
            throw new InvalidArgumentException('Device not found');
        }

        $this->device = $device;

        $this->config = $device->Config;
    }

    public function getXML() {

        // create a new XML document
        $doc = new DomDocument('1.0');
        $this->doc = $doc;
        
        // create root node
        $root = $doc->createElement('config');
        $this->root = $root;
        
        $root->setAttribute('version', self::VERSION);
        $doc->appendChild($root);

        $this->createTextNode('update_server', $this->config->update_server, $root);

        $hardware = $doc->createElement('hardware');
        $root->appendChild($hardware);

        $this->createTextNode('mode', $this->config->wireless_mode, $hardware);
        $this->createTextNode('channel', $this->config->wireless_channel, $hardware);

        foreach ($this->config->Mode1s as $mode1) {
            $this->generateSsidConf($mode1, $root, 1);
        }

        foreach ($this->config->Mode2s as $mode2) {
            $ssid = $this->generateSsidConf($mode2, $root, 2);

            $portal = $doc->createElement('portal');
            $ssid->appendChild($portal);

            $this->createTextNode('remote_file', '/uploads/portal/'.$mode2->file_name, $portal);

            $this->generateRadiusConf($mode2, $portal);
        }

        foreach ($this->config->Mode3s as $mode3) {
            $ssid = $this->generateSsidConf($mode3, $root, 3);

            $this->createTextNode('traffic_mode', $mode3->traffic_mode, $ssid);

            $hostapd = $ssid->getElementsByTagName('hostapd')->item(0);
            $this->generateRadiusConf($mode3, $hostapd);

            $openvpn = $doc->createElement('openvpn');
            $ssid->appendChild($openvpn);

            $mode3_cert = Mode3CertificateTable::getFromMode3AndDevice($mode3, $this->device);
            if ($mode3_cert) {
                $certs = $doc->createElement('certificates');
                $openvpn->appendChild($certs);

                $key = $this->createTextNode('cert', $mode3_cert->public_key, $certs);
                $key->setAttribute('name', $mode3_cert->public_key_name);

                $key = $this->createTextNode('key', $mode3_cert->private_key, $certs);
                $key->setAttribute('name', $mode3_cert->private_key_name);

                $key = $this->createTextNode('ca', $mode3_cert->cert_of_authority, $certs);
            }

            $auth = $doc->createElement('tunnel');
            $auth->setAttribute('type', 'auth');
            $openvpn->appendChild($auth);
            $this->createTextNode('server', $mode3->vpn_auth_server, $auth);
            $this->createTextNode('port', $mode3->vpn_auth_port, $auth);
            $this->createTextNode('cipher', $mode3->vpn_auth_cipher, $auth);
            $this->createTextNode('compression', $mode3->vpn_auth_compression ? 'true' : 'false', $auth);

            if ($mode3->traffic_mode == 'tunnel_to_data_tunnel') {
                $data = $doc->createElement('tunnel');
                $data->setAttribute('type', 'data');
                $openvpn->appendChild($data);
                $this->createTextNode('server', $mode3->vpn_data_server, $data);
                $this->createTextNode('port', $mode3->vpn_data_port, $data);
                $this->createTextNode('cipher', $mode3->vpn_data_cipher, $data);
                $this->createTextNode('compression', $mode3->vpn_data_compression ? 'true' : 'false', $data);
            }
        }

        return $doc->saveXML();
    }
    protected function generateSsidConf($ssid_obj, $root, $mode = 1) {
        $ssid = $this->doc->createElement('ssid');
        $ssid->setAttribute('mode', $mode);
        $root->appendChild($ssid);

        $hostapd = $this->doc->createElement('hostapd');
        $ssid->appendChild($hostapd);

        $this->createTextNode('ssid_name', $ssid_obj->name, $hostapd);
        $this->createTextNode('broadcast', $ssid_obj->broadcast ? 'true' : 'false', $hostapd);

        $vlan = $this->doc->createElement('vlan');
        $hostapd->appendChild($vlan);
        $vlan->setAttribute('enable', $ssid_obj->vlan != null ? 'true' : 'false');
        if ($ssid_obj->vlan != null) {
            $this->createTextNode('vlan_id', $ssid_obj->vlan, $vlan);
        }

        if ($mode == 1) {
            $wpa = $this->doc->createElement('wpa');
            $hostapd->appendChild($wpa);
            $wpa->setAttribute('mode', $ssid_obj->wpa_mode);
            
            $this->createTextNode('group_rekey_interval', $ssid_obj->group_rekey_interval, $wpa);
            $this->createTextNode('strict_rekey', $ssid_obj->strict_rekey ? 'true' : 'false', $wpa);
            $this->createTextNode('passphrase', $ssid_obj->passphrase, $wpa);
        }
        
        return $ssid;
    }
    protected function generateRadiusConf($radius_obj, $root) {
        $radius = $this->doc->createElement('radius');
        $root->appendChild($radius);

        $this->createTextNode('own_ip', $radius_obj->own_ip, $radius);
        $this->createTextNode('nas_identifier', $radius_obj->nas_identifier, $radius);

        $auth = $this->doc->createElement('auth_server');
        $radius->appendChild($auth);
        $this->createTextNode('ip', $radius_obj->radius_auth_ip, $auth);
        $this->createTextNode('port', $radius_obj->radius_auth_port, $auth);
        $this->createTextNode('shared_secret', $radius_obj->radius_auth_shared_secret, $auth);

        $acct = $this->doc->createElement('acct_server');
        $radius->appendChild($acct);
        $this->createTextNode('ip', $radius_obj->radius_acct_ip, $acct);
        $this->createTextNode('port', $radius_obj->radius_acct_port, $acct);
        $this->createTextNode('shared_secret', $radius_obj->radius_acct_shared_secret, $acct);
        $this->createTextNode('interim_interval', $radius_obj->radius_acct_interim_interval, $acct);

        return $radius;
    }
    protected function createTextNode($name, $text, $parent) {
        $node = $this->doc->createElement($name);
        $parent->appendChild($node);
        $node->appendChild($this->doc->createTextNode($text));

        return $node;
    }
}