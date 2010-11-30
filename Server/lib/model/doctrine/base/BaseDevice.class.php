<?php

/**
 * BaseDevice
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $config_id
 * @property string $description
 * @property Config $Config
 * 
 * @method integer getId()          Returns the current record's "id" value
 * @method integer getConfigId()    Returns the current record's "config_id" value
 * @method string  getDescription() Returns the current record's "description" value
 * @method Config  getConfig()      Returns the current record's "Config" value
 * @method Device  setId()          Sets the current record's "id" value
 * @method Device  setConfigId()    Sets the current record's "config_id" value
 * @method Device  setDescription() Sets the current record's "description" value
 * @method Device  setConfig()      Sets the current record's "Config" value
 * 
 * @package    sf_sandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDevice extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('device');
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
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Config', array(
             'local' => 'config_id',
             'foreign' => 'id'));
    }
}