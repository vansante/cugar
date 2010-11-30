<?php

/**
 * Ssid form base class.
 *
 * @method Ssid getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSsidForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'device_config_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DeviceConfig'), 'add_empty' => false)),
      'name'                 => new sfWidgetFormInputText(),
      'vlan'                 => new sfWidgetFormInputText(),
      'group_rekey_interval' => new sfWidgetFormInputText(),
      'broadcast'            => new sfWidgetFormInputCheckbox(),
      'strict_rekey'         => new sfWidgetFormInputCheckbox(),
      'passprase'            => new sfWidgetFormInputText(),
      'wpa_mode'             => new sfWidgetFormChoice(array('choices' => array('wpa' => 'wpa', 'wpa2' => 'wpa2', 'off' => 'off'))),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'device_config_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DeviceConfig'))),
      'name'                 => new sfValidatorString(array('max_length' => 32, 'min_length' => 1)),
      'vlan'                 => new sfValidatorInteger(),
      'group_rekey_interval' => new sfValidatorInteger(),
      'broadcast'            => new sfValidatorBoolean(),
      'strict_rekey'         => new sfValidatorBoolean(),
      'passprase'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'wpa_mode'             => new sfValidatorChoice(array('choices' => array(0 => 'wpa', 1 => 'wpa2', 2 => 'off'))),
    ));

    $this->widgetSchema->setNameFormat('ssid[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ssid';
  }

}
