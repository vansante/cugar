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
      'config_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Config'), 'add_empty' => false)),
      'name'                 => new sfWidgetFormInputText(),
      'mode'                 => new sfWidgetFormChoice(array('choices' => array(1 => 1, 2 => 2, 3 => 3))),
      'vlan'                 => new sfWidgetFormInputText(),
      'wpa_mode'             => new sfWidgetFormChoice(array('choices' => array('wpa' => 'wpa', 'wpa2' => 'wpa2', 'off' => 'off'))),
      'broadcast'            => new sfWidgetFormInputCheckbox(),
      'passphrase'           => new sfWidgetFormInputText(),
      'group_rekey_interval' => new sfWidgetFormInputText(),
      'strict_rekey'         => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'config_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Config'))),
      'name'                 => new sfValidatorString(array('max_length' => 32, 'min_length' => 1)),
      'mode'                 => new sfValidatorChoice(array('choices' => array(0 => 1, 1 => 2, 2 => 3), 'required' => false)),
      'vlan'                 => new sfValidatorInteger(array('required' => false)),
      'wpa_mode'             => new sfValidatorChoice(array('choices' => array(0 => 'wpa', 1 => 'wpa2', 2 => 'off'), 'required' => false)),
      'broadcast'            => new sfValidatorBoolean(array('required' => false)),
      'passphrase'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'group_rekey_interval' => new sfValidatorInteger(),
      'strict_rekey'         => new sfValidatorBoolean(),
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
