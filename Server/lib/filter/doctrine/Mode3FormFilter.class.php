<?php

/**
 * Mode3 filter form.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Mode3FormFilter extends BaseMode3FormFilter {
    
    /**
     * @see ModeFormFilter
     */
    public function configure() {

        $this->useFields(array(
            'config_id', 'name', 'vlan', 'broadcast', 'radius_auth_ip', 'radius_acct_ip', 'vpn_auth_server', 'vpn_data_server'
        ));
    }

}
