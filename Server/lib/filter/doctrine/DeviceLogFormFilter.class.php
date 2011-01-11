<?php

/**
 * DeviceLog filter form.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DeviceLogFormFilter extends BaseDeviceLogFormFilter {

    public function configure() {
        unset($this['description']);
    }

}
