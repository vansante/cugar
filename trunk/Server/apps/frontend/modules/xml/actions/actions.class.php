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

        $this->forward404Unless($this->checkDevice($cert_name, $cert_name_encrypted), 'Name check failed ('.$cert_name.' / '.$cert_name_encrypted.')');

        $device = DeviceTable::getFromCertificateName($cert_name);
        
        $this->forward404Unless($device, 'Device not found in database');

        $xml = new XMLConfig($device);

        $this->xml = $xml->getXML();
    }

    protected function checkDevice($cert_name, $cert_name_encrypted) {
        if (!strlen($cert_name) || !strlen($cert_name_encrypted)) {
            return false;
        }

        $cert_dir = sfConfig::get('app_certificate_dir');
        $file = $cert_dir.DIRECTORY_SEPARATOR.$cert_name.'.crt';

        if (!file_exists($file)) {
            return false;
        }

        $key = file_get_contents($file);

        $cert_name_decrypted = false;
        $result = openssl_public_decrypt($cert_name_enc, $cert_name_decrypted, $key);
        
        return $result && $cert_name == $cert_name_decrypted;
    }
}
