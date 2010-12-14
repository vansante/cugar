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
            'own_ip' => 'Radius own IP address',
            'nas_identifier' => 'Radius NAS identifier',
            'radius_auth_ip' => 'Authentication radius server IP',
            'radius_auth_port' => 'Authentication radius server port',
            'radius_auth_shared_secret' => 'Authentication radius server shared secret',
            'radius_acct_ip' => 'Accounting radius server IP',
            'radius_acct_port' => 'Accounting radius server port',
            'radius_acct_shared_secret' => 'Accounting radius server shared secret',
            'radius_acct_interim_interval' => 'Accounting radius server interim interval',
        ));
    }

}
