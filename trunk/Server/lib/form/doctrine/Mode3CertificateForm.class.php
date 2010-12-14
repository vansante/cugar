<?php

/**
 * Mode3Certificate form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Mode3CertificateForm extends BaseMode3CertificateForm {

    public function configure() {
        
        $this->widgetSchema->setLabels(array(
            'mode3_id' => 'Mode 3 SSID config',
        ));
    }

}
