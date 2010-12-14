<?php

/**
 * Ssid form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SsidForm extends BaseSsidForm {

    public function configure() {
        $this->widgetSchema->setLabels(array(
            'name' => 'SSID name',
            'vlan' => 'VLAN id',
            'wpa_mode' => 'WPA mode',
            'broadcast' => 'Broadcast SSID',
        ));
    }

}
