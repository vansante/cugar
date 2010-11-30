<?php

/**
 * Mode2 form base class.
 *
 * @method Mode2 getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMode2Form extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'ssid_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ssid'), 'add_empty' => true)),
      'file_path' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ssid_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Ssid'), 'required' => false)),
      'file_path' => new sfValidatorString(array('max_length' => 255, 'min_length' => 4)),
    ));

    $this->widgetSchema->setNameFormat('mode2[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Mode2';
  }

}
