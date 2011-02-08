<?php

/**
 * BaseConfig
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $update_server
 * @property int $wireless_channel
 * @property enum $wireless_mode
 * @property Doctrine_Collection $Devices
 * @property Doctrine_Collection $Mode1s
 * @property Doctrine_Collection $Mode2s
 * @property Doctrine_Collection $Mode3s
 * 
 * @method integer             getId()               Returns the current record's "id" value
 * @method string              getName()             Returns the current record's "name" value
 * @method string              getUpdateServer()     Returns the current record's "update_server" value
 * @method int                 getWirelessChannel()  Returns the current record's "wireless_channel" value
 * @method enum                getWirelessMode()     Returns the current record's "wireless_mode" value
 * @method Doctrine_Collection getDevices()          Returns the current record's "Devices" collection
 * @method Doctrine_Collection getMode1s()           Returns the current record's "Mode1s" collection
 * @method Doctrine_Collection getMode2s()           Returns the current record's "Mode2s" collection
 * @method Doctrine_Collection getMode3s()           Returns the current record's "Mode3s" collection
 * @method Config              setId()               Sets the current record's "id" value
 * @method Config              setName()             Sets the current record's "name" value
 * @method Config              setUpdateServer()     Sets the current record's "update_server" value
 * @method Config              setWirelessChannel()  Sets the current record's "wireless_channel" value
 * @method Config              setWirelessMode()     Sets the current record's "wireless_mode" value
 * @method Config              setDevices()          Sets the current record's "Devices" collection
 * @method Config              setMode1s()           Sets the current record's "Mode1s" collection
 * @method Config              setMode2s()           Sets the current record's "Mode2s" collection
 * @method Config              setMode3s()           Sets the current record's "Mode3s" collection
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseConfig extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('config');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'autoincrement' => true,
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 50, array(
             'type' => 'string',
             'minlength' => 1,
             'notnull' => true,
             'length' => 50,
             ));
        $this->hasColumn('update_server', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'minlength' => 3,
             'length' => 255,
             ));
        $this->hasColumn('wireless_channel', 'int', 2, array(
             'type' => 'int',
             'minlength' => 1,
             'unsigned' => true,
             'range' => 
             array(
              0 => 1,
              1 => 13,
             ),
             'length' => 2,
             ));
        $this->hasColumn('wireless_mode', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'auto',
              1 => 'B',
              2 => 'G',
              3 => 'N',
             ),
             'default' => 'auto',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Device as Devices', array(
             'local' => 'id',
             'foreign' => 'config_id'));

        $this->hasMany('Mode1 as Mode1s', array(
             'local' => 'id',
             'foreign' => 'config_id'));

        $this->hasMany('Mode2 as Mode2s', array(
             'local' => 'id',
             'foreign' => 'config_id'));

        $this->hasMany('Mode3 as Mode3s', array(
             'local' => 'id',
             'foreign' => 'config_id'));
    }
}