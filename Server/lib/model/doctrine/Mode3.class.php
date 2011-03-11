<?php

/**
 * Mode3
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Mode3 extends BaseMode3 {

    public function  validate() {
        $errorStack = $this->getErrorStack();

        if ($this->vpn_data_server) {
            if (!$this->vpn_data_port) {
                $errorStack->add('passphrase', "Please supply a data vpn server port");
            }
        }
    }

    public function __toString() {
        return $this->name;
    }

    public function preSave($event) {

        if ($this->vpn_data_server == '') {
            $this->vpn_data_server = null;
        }
        if ($this->vpn_data_port == '') {
            $this->vpn_data_port = null;
        }
    }
}