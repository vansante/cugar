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

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeGet(sfWebRequest $request) {

        $device = DeviceTable::getByCertificateName($request->getParameter('cert_name'));
        
        $this->forward404Unless($device, 'Device not found');

        $xml = new XMLConfig($device);

        $this->xml = $xml->getXML();
    }

}
