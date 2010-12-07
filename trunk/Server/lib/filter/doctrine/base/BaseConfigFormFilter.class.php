<?php

/**
 * Config filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseConfigFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'update_server'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'wireless_channel' => new sfWidgetFormFilterInput(),
      'wireless_mode'    => new sfWidgetFormChoice(array('choices' => array('' => '', 'auto' => 'auto', 'B' => 'B', 'G' => 'G', 'N' => 'N'))),
    ));

    $this->setValidators(array(
      'name'             => new sfValidatorPass(array('required' => false)),
      'update_server'    => new sfValidatorPass(array('required' => false)),
      'wireless_channel' => new sfValidatorPass(array('required' => false)),
      'wireless_mode'    => new sfValidatorChoice(array('required' => false, 'choices' => array('auto' => 'auto', 'B' => 'B', 'G' => 'G', 'N' => 'N'))),
    ));

    $this->widgetSchema->setNameFormat('config_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Config';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'name'             => 'Text',
      'update_server'    => 'Text',
      'wireless_channel' => 'Text',
      'wireless_mode'    => 'Enum',
    );
  }
}
