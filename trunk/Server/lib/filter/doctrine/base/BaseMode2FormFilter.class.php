<?php

/**
 * Mode2 filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMode2FormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ssid_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ssid'), 'add_empty' => true)),
      'file_path' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'ssid_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Ssid'), 'column' => 'id')),
      'file_path' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mode2_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Mode2';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'ssid_id'   => 'ForeignKey',
      'file_path' => 'Text',
    );
  }
}
