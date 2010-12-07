<?php

/**
 * Mode3Certificate form base class.
 *
 * @method Mode3Certificate getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMode3CertificateForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'mode3_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Mode3'), 'add_empty' => false)),
      'device_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Device'), 'add_empty' => false)),
      'public_key'        => new sfWidgetFormTextarea(),
      'private_key'       => new sfWidgetFormTextarea(),
      'cert_of_authority' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'mode3_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Mode3'))),
      'device_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Device'))),
      'public_key'        => new sfValidatorString(),
      'private_key'       => new sfValidatorString(),
      'cert_of_authority' => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('mode3_certificate[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Mode3Certificate';
  }

}
