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
            'vpn_auth_server' => 'Authentication VPN tunnel server',
            'vpn_auth_port' => 'Authentication VPN tunnel port',
            'vpn_auth_cipher' => 'Authentication VPN tunnel cipher',
            'vpn_auth_compression' => 'Authentication VPN tunnel compression',
            'vpn_data_server' => 'Update VPN tunnel server',
            'vpn_data_port' => 'Update VPN tunnel port',
            'vpn_data_cipher' => 'Update VPN tunnel cipher',
            'vpn_data_compression' => 'Update VPN tunnel compression',
        ));
    }

}
