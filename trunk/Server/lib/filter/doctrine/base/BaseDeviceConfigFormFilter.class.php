<?php

/**
 * DeviceConfig filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDeviceConfigFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'wireless_channel' => new sfWidgetFormFilterInput(),
      'wireless_mode'    => new sfWidgetFormChoice(array('choices' => array('' => '', 'b' => 'b', 'g' => 'g', 'n' => 'n', 'auto' => 'auto'))),
      'update_server'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'wireless_channel' => new sfValidatorPass(array('required' => false)),
      'wireless_mode'    => new sfValidatorChoice(array('required' => false, 'choices' => array('b' => 'b', 'g' => 'g', 'n' => 'n', 'auto' => 'auto'))),
      'update_server'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('device_config_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DeviceConfig';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'wireless_channel' => 'Text',
      'wireless_mode'    => 'Enum',
      'update_server'    => 'Text',
    );
  }
}
