<?php

/**
 * Mode3 form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Mode3Form extends BaseMode3Form {

    public function configure() {
        parent::configure();

        $this->widgetSchema->setLabels(array(
            'vpn_auth_server' => 'Server IP address',
            'vpn_auth_port' => 'Server port',
            'vpn_auth_cipher' => 'Encryption cipher',
            'vpn_auth_compression' => 'Use compression',
            'vpn_data_server' => 'Server IP address',
            'vpn_data_port' => 'Server port',
            'vpn_data_cipher' => 'Encryption cipher',
            'vpn_data_compression' => 'Use compression',
        ));

        $this->setWidget('vpn_data_server', new sfWidgetFormFilterInput());
    }
}
