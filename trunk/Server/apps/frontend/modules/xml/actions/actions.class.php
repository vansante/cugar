<?php

/**
 * xml actions.
 *
 * @package    sf_sandbox
 * @subpackage xml
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class xmlActions extends sfActions {


    public function executeGet(sfWebRequest $request) {

        $cert_name = $request->getParameter('cert_name');
        $cert_name_encrypted = $request->getParameter('cert_name_check');

        $this->checkDevice($cert_name, $cert_name_encrypted);

        $device = DeviceTable::getFromCertificateName($cert_name);
        
        $this->forward404Unless($device, 'Device not found in database');

        $xml = new XMLConfig($device);

        $this->xml = $xml->getXML();
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

        $cert_name_decrypted = false;
        $result = openssl_public_decrypt($cert_name_enc, $cert_name_decrypted, $key);

        if (!$result) {
            $this->forward404('Decryption failed');
        }

        if ($cert_name != $cert_name_decrypted) {
            $this->forward404('Name check failed ('.$cert_name.' / '.$cert_name_decrypted.')');
        }

    }
}
