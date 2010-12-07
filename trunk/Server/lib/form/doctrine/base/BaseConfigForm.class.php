<?php

/**
 * Config form base class.
 *
 * @method Config getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseConfigForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'wireless_channel' => new sfWidgetFormInputText(),
      'wireless_mode'    => new sfWidgetFormChoice(array('choices' => array('B' => 'B', 'G' => 'G', 'N' => 'N', 'auto' => 'auto'))),
      'update_server'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'wireless_channel' => new sfValidatorPass(array('required' => false)),
      'wireless_mode'    => new sfValidatorChoice(array('choices' => array(0 => 'B', 1 => 'G', 2 => 'N', 3 => 'auto'))),
      'update_server'    => new sfValidatorString(array('max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('config[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Config';
  }

}
