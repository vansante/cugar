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
      'mode'                 => new sfWidgetFormChoice(array('choices' => array('' => '', 1 => 1, 2 => 2, 3 => 3))),
      'name'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'vlan'                 => new sfWidgetFormFilterInput(),
      'group_rekey_interval' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'broadcast'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'strict_rekey'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'passprase'            => new sfWidgetFormFilterInput(),
      'wpa_mode'             => new sfWidgetFormChoice(array('choices' => array('' => '', 'wpa' => 'wpa', 'wpa2' => 'wpa2', 'off' => 'off'))),
    ));

    $this->setValidators(array(
      'config_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Config'), 'column' => 'id')),
      'mode'                 => new sfValidatorChoice(array('required' => false, 'choices' => array(1 => 1, 2 => 2, 3 => 3))),
      'name'                 => new sfValidatorPass(array('required' => false)),
      'vlan'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'group_rekey_interval' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'broadcast'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'strict_rekey'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'passprase'            => new sfValidatorPass(array('required' => false)),
      'wpa_mode'             => new sfValidatorChoice(array('required' => false, 'choices' => array('wpa' => 'wpa', 'wpa2' => 'wpa2', 'off' => 'off'))),
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
      'mode'                 => 'Enum',
      'name'                 => 'Text',
      'vlan'                 => 'Number',
      'group_rekey_interval' => 'Number',
      'broadcast'            => 'Boolean',
      'strict_rekey'         => 'Boolean',
      'passprase'            => 'Text',
      'wpa_mode'             => 'Enum',
    );
  }
}
