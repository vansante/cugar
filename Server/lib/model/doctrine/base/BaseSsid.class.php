<?php

/**
 * BaseSsid
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $config_id
 * @property string $name
 * @property integer $vlan
 * @property integer $group_rekey_interval
 * @property boolean $broadcast
 * @property boolean $strict_rekey
 * @property string $passprase
 * @property enum $wpa_mode
 * @property Config $Config
 * @property Mode2 $Mode2s
 * @property Mode3 $Mode3s
 * 
 * @method integer getId()                   Returns the current record's "id" value
 * @method integer getConfigId()             Returns the current record's "config_id" value
 * @method string  getName()                 Returns the current record's "name" value
 * @method integer getVlan()                 Returns the current record's "vlan" value
 * @method integer getGroupRekeyInterval()   Returns the current record's "group_rekey_interval" value
 * @method boolean getBroadcast()            Returns the current record's "broadcast" value
 * @method boolean getStrictRekey()          Returns the current record's "strict_rekey" value
 * @method string  getPassprase()            Returns the current record's "passprase" value
 * @method enum    getWpaMode()              Returns the current record's "wpa_mode" value
 * @method Config  getConfig()               Returns the current record's "Config" value
 * @method Mode2   getMode2s()               Returns the current record's "Mode2s" value
 * @method Mode3   getMode3s()               Returns the current record's "Mode3s" value
 * @method Ssid    setId()                   Sets the current record's "id" value
 * @method Ssid    setConfigId()             Sets the current record's "config_id" value
 * @method Ssid    setName()                 Sets the current record's "name" value
 * @method Ssid    setVlan()                 Sets the current record's "vlan" value
 * @method Ssid    setGroupRekeyInterval()   Sets the current record's "group_rekey_interval" value
 * @method Ssid    setBroadcast()            Sets the current record's "broadcast" value
 * @method Ssid    setStrictRekey()          Sets the current record's "strict_rekey" value
 * @method Ssid    setPassprase()            Sets the current record's "passprase" value
 * @method Ssid    setWpaMode()              Sets the current record's "wpa_mode" value
 * @method Ssid    setConfig()               Sets the current record's "Config" value
 * @method Ssid    setMode2s()               Sets the current record's "Mode2s" value
 * @method Ssid    setMode3s()               Sets the current record's "Mode3s" value
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSsid extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ssid');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'autoincrement' => true,
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('config_id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 32, array(
             'type' => 'string',
             'notnull' => true,
             'minlength' => 1,
             'length' => 32,
             ));
        $this->hasColumn('vlan', 'integer', 2, array(
             'type' => 'integer',
             'notnull' => false,
             'range' => 
             array(
              0 => 1,
              1 => 4096,
             ),
             'length' => 2,
             ));
        $this->hasColumn('group_rekey_interval', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('broadcast', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             ));
        $this->hasColumn('strict_rekey', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             ));
        $this->hasColumn('passprase', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
        $this->hasColumn('wpa_mode', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'wpa',
              1 => 'wpa2',
              2 => 'off',
             ),
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Config', array(
             'local' => 'config_id',
             'foreign' => 'id'));

        $this->hasOne('Mode2 as Mode2s', array(
             'local' => 'id',
             'foreign' => 'ssid_id'));

        $this->hasOne('Mode3 as Mode3s', array(
             'local' => 'id',
             'foreign' => 'ssid_id'));
    }
}