<?php

/**
 * Mode3Certificate filter form.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Mode3CertificateFormFilter extends BaseMode3CertificateFormFilter {

    public function configure() {
        unset(
            $this['public_key'],
            $this['private_key'],
            $this['cert_of_authority']
        );
    }

}
