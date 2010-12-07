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
      'config_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Config'), 'add_empty' => true)),
      'name'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mode'                 => new sfWidgetFormChoice(array('choices' => array('' => '', 1 => 1, 2 => 2, 3 => 3))),
      'vlan'                 => new sfWidgetFormFilterInput(),
      'wpa_mode'             => new sfWidgetFormChoice(array('choices' => array('' => '', 'wpa' => 'wpa', 'wpa2' => 'wpa2', 'off' => 'off'))),
      'broadcast'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'passphrase'           => new sfWidgetFormFilterInput(),
      'group_rekey_interval' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'strict_rekey'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'config_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Config'), 'column' => 'id')),
      'name'                 => new sfValidatorPass(array('required' => false)),
      'mode'                 => new sfValidatorChoice(array('required' => false, 'choices' => array(1 => 1, 2 => 2, 3 => 3))),
      'vlan'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'wpa_mode'             => new sfValidatorChoice(array('required' => false, 'choices' => array('wpa' => 'wpa', 'wpa2' => 'wpa2', 'off' => 'off'))),
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
      'config_id'            => 'ForeignKey',
      'name'                 => 'Text',
      'mode'                 => 'Enum',
      'vlan'                 => 'Number',
      'wpa_mode'             => 'Enum',
      'broadcast'            => 'Boolean',
      'passphrase'           => 'Text',
      'group_rekey_interval' => 'Number',
      'strict_rekey'         => 'Boolean',
    );
  }
}
