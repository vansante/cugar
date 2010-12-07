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
      'name'             => new sfWidgetFormInputText(),
      'update_server'    => new sfWidgetFormInputText(),
      'wireless_channel' => new sfWidgetFormInputText(),
      'wireless_mode'    => new sfWidgetFormChoice(array('choices' => array('auto' => 'auto', 'B' => 'B', 'G' => 'G', 'N' => 'N'))),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 50, 'min_length' => 1)),
      'update_server'    => new sfValidatorString(array('max_length' => 255, 'min_length' => 3)),
      'wireless_channel' => new sfValidatorPass(array('required' => false)),
      'wireless_mode'    => new sfValidatorChoice(array('choices' => array(0 => 'auto', 1 => 'B', 2 => 'G', 3 => 'N'), 'required' => false)),
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
