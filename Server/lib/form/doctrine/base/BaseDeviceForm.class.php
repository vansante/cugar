<?php

/**
 * Device form base class.
 *
 * @method Device getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDeviceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'device_config_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DeviceConfig'), 'add_empty' => false)),
      'description'      => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'device_config_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DeviceConfig'))),
      'description'      => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('device[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Device';
  }

}
