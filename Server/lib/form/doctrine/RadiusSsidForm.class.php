<?php

/**
 * RadiusSsid form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RadiusSsidForm extends BaseRadiusSsidForm {

    /**
     * @see SsidForm
     */
    public function configure() {
        parent::configure();

        $this->widgetSchema->setLabels(array(
            'own_ip' => 'Own IP address',
            'nas_identifier' => 'NAS identifier',
            'radius_auth_ip' => 'Server IP address',
            'radius_auth_port' => 'Server port',
            'radius_auth_shared_secret' => 'Shared secret',
            'radius_acct_ip' => 'Server IP address',
            'radius_acct_port' => 'Server port',
            'radius_acct_shared_secret' => 'Shared secret',
            'radius_acct_interim_interval' => 'Interim interval',
        ));
    }

}
