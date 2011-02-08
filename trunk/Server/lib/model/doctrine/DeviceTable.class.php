<?php

/**
 * DeviceTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class DeviceTable extends Doctrine_Table {

    /**
     * Returns an instance of this class.
     *
     * @return object DeviceTable
     */
    public static function getInstance() {
        return Doctrine_Core::getTable('Device');
    }

    public static function getFromCertificateName($cert_name) {
        return Doctrine_Query::create()
            ->from('Device d')
            ->where('d.certificate_name = ?', $cert_name)
            ->fetchOne();
    }

}