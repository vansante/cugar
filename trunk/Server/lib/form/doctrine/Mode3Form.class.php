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
            'dhcp_hw_interface' => 'DHCP hardware interface',
            'vpn_auth_server' => 'VPN authentication tunnel server',
            'vpn_auth_port' => 'VPN authentication tunnel port',
            'vpn_auth_cipher' => 'VPN authentication tunnel cipher',
            'vpn_auth_compression' => 'VPN authentication tunnel compression',
            'vpn_data_server' => 'VPN data tunnel server',
            'vpn_data_port' => 'VPN data tunnel port',
            'vpn_data_cipher' => 'VPN data tunnel cipher',
            'vpn_data_compression' => 'VPN data tunnel compression',
        ));
    }

}
