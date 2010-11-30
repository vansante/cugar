<?php

/**
 * Device filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDeviceFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'device_config_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DeviceConfig'), 'add_empty' => true)),
      'description'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'device_config_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DeviceConfig'), 'column' => 'id')),
      'description'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('device_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Device';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'device_config_id' => 'ForeignKey',
      'description'      => 'Text',
    );
  }
}
