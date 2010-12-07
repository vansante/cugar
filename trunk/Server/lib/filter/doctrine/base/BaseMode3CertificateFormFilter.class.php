<?php

/**
 * Mode3Certificate filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMode3CertificateFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mode3_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Mode3'), 'add_empty' => true)),
      'device_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Device'), 'add_empty' => true)),
      'public_key'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'private_key'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cert_of_authority' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'mode3_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Mode3'), 'column' => 'id')),
      'device_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Device'), 'column' => 'id')),
      'public_key'        => new sfValidatorPass(array('required' => false)),
      'private_key'       => new sfValidatorPass(array('required' => false)),
      'cert_of_authority' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mode3_certificate_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Mode3Certificate';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'mode3_id'          => 'ForeignKey',
      'device_id'         => 'ForeignKey',
      'public_key'        => 'Text',
      'private_key'       => 'Text',
      'cert_of_authority' => 'Text',
    );
  }
}
