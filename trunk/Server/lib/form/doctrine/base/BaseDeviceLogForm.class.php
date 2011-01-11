<?php

/**
 * DeviceLog form base class.
 *
 * @method DeviceLog getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDeviceLogForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'device_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Device'), 'add_empty' => false)),
      'time'        => new sfWidgetFormDateTime(),
      'description' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'device_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Device'))),
      'time'        => new sfValidatorDateTime(),
      'description' => new sfValidatorPass(),
    ));

    $this->widgetSchema->setNameFormat('device_log[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DeviceLog';
  }

}
