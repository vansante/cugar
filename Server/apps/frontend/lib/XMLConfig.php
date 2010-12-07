<?php

class XMLConfig {

    const VERSION = 0.1;

    protected $device, $config;

    protected $doc;
    
    public function  __construct($device) {
        if (!$device instanceof Device) {
            $device = DeviceTable::getInstance()->find($device);
        }
        throw new InvalidArgumentException('Device not found');

        $this->device = $device;

        $this->config = $device->Config;
    }

    public function getXML() {

        // create a new XML document
        $doc = new DomDocument('1.0');
        $this->doc = $doc;
        
        // create root node
        $root = $doc->createElement('config');
        $root->setAttribute('version', self::VERSION);
        $doc->appendChild($root);

        $this->createTextNode('update_server', $this->config->update_server, $doc);

        $hardware = $doc->createElement('hardware');
        $root->appendChild($hardware);

        $this->createTextNode('mode', $this->config->wireless_mode, $hardware);
        $this->createTextNode('channel', $this->config->wireless_channel, $hardware);

        foreach ($this->config->Ssids as $ssid_obj) {
            $ssid = $doc->createElement('ssid');
            $ssid->setAttribute('mode', $ssid_obj->mode);
            $root->appendChild($ssid);

            $hostapd = $doc->createElement('hostapd');
            $ssid->appendChild($hostapd);

            $this->createTextNode('ssid_name', $ssid_obj->name, $ssid);
            $this->createTextNode('broadcast', $ssid_obj->broadcast, $ssid);

            $vlan = $doc->createElement('vlan');
            $hostapd->appendChild($vlan);
            $vlan->setAttribute('enable', $ssid_obj->vlan != null);
            if ($ssid_obj->vlan != null) {
                $this->createTextNode('vlan_id', $ssid_obj->vlan, $vlan);
            }

            $wpa = $doc->createElement('wpa');
            $hostapd->appendChild($wpa);
            $wpa->setAttribute('mode', $ssid_obj->wpa_mode);
            $this->createTextNode('group_rekey_interval', $ssid_obj->group_rekey_interval, $wpa);
            $this->createTextNode('strict_rekey', $ssid_obj->strict_rekey, $wpa);
            $this->createTextNode('passphrase', $ssid_obj->passphrase, $wpa);

            if ($ssid_obj->mode == 2) {

            } else if ($ssid_obj->mode == 3) {
                
            }
        }

        return $dom->saveXML();
    }
    protected function createTextNode($name, $text, $parent) {
        $node = $this->doc->createElement($name);
        $parent->appendChild($node);
        $node->appendChild($this->doc->createTextNode($text));
    }
}