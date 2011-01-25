<?php

/**
 * xml actions.
 *
 * @package    sf_sandbox
 * @subpackage xml
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class deviceInterfaceActions extends sfActions {

    public function executeGetXml(sfWebRequest $request) {

        $cert_name = $request->getParameter('cert_name');
        $cert_name_encrypted = $request->getParameter('cert_name_check');

        $this->checkDevice($cert_name, $cert_name_encrypted);

        $device = DeviceTable::getFromCertificateName(str_replace('.key', '', $cert_name));
        
        $this->forward404Unless($device, 'Device not found in database');

        $xml = new XMLConfig($device);

        $this->xml = $xml->getXML();
    }

    public function executePostError(sfWebRequest $request) {

        $cert_name = $request->getParameter('cert_name');
        $cert_name_encrypted = $request->getParameter('cert_name_check');

        $this->checkDevice($cert_name, $cert_name_encrypted);

        $device = DeviceTable::getFromCertificateName(str_replace('.key', '', $cert_name));

        $this->forward404Unless($device, 'Device not found in database');

        $time = $request->getParameter('time');
        $date = date_parse_from_format('Y-m-d H:i:s', $time);
        $this->forward404If($date['error_count'], 'The supplied time ('.$time.') is in an invalid format');

        $descr = $request->getParameter('description');
        $this->forward404Unless(strlen($descr), 'Description is empty');
        
        DeviceLogTable::addLog($device, $time, $descr);
    }

    protected function checkDevice($cert_name, $cert_name_encrypted) {
        if (!strlen($cert_name) || !strlen($cert_name_encrypted)) {
            $this->forward404('Invalid arguments ('.$cert_name.' / '.$cert_name_encrypted.')');
        }

        $cert_dir = sfConfig::get('app_certificate_dir');
        $file = $cert_dir . DIRECTORY_SEPARATOR . str_replace('.key', '.crt', $cert_name);

        if (!file_exists($file)) {
            $this->forward404('Keyfile not found ('.$file.')');
        }

        $key = file_get_contents($file);

        if (!strlen($key)) {
            $this->forward404('Key is empty');
        }

        $cert_name_decrypted = false;
        $result = openssl_public_decrypt($cert_name_encrypted, $cert_name_decrypted, $key);

        if (!$result) {
            $this->forward404('Decryption failed');
        }

        if ($cert_name != $cert_name_decrypted) {
            $this->forward404('Name check failed ('.$cert_name.' / '.$cert_name_decrypted.')');
        }

    }
}
