<?php

/**
 * Ssid filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSsidFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'wpa_mode'             => new sfWidgetFormChoice(array('choices' => array('' => '', 'wpa' => 'wpa', 'wpa2' => 'wpa2', 'off' => 'off'))),
      'vlan'                 => new sfWidgetFormFilterInput(),
      'broadcast'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'passphrase'           => new sfWidgetFormFilterInput(),
      'group_rekey_interval' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'strict_rekey'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'name'                 => new sfValidatorPass(array('required' => false)),
      'wpa_mode'             => new sfValidatorChoice(array('required' => false, 'choices' => array('wpa' => 'wpa', 'wpa2' => 'wpa2', 'off' => 'off'))),
      'vlan'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'broadcast'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'passphrase'           => new sfValidatorPass(array('required' => false)),
      'group_rekey_interval' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'strict_rekey'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('ssid_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ssid';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'name'                 => 'Text',
      'wpa_mode'             => 'Enum',
      'vlan'                 => 'Number',
      'broadcast'            => 'Boolean',
      'passphrase'           => 'Text',
      'group_rekey_interval' => 'Number',
      'strict_rekey'         => 'Boolean',
    );
  }
}
