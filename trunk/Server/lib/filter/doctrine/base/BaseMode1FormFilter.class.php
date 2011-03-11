<?php

/**
 * Mode1 filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMode1FormFilter extends SsidFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['config_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Config'), 'add_empty' => true));
    $this->validatorSchema['config_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Config'), 'column' => 'id'));

    $this->widgetSchema   ['wpa_mode'] = new sfWidgetFormChoice(array('choices' => array('' => '', 'wpa' => 'wpa', 'wpa2' => 'wpa2', 'off' => 'off')));
    $this->validatorSchema['wpa_mode'] = new sfValidatorChoice(array('required' => false, 'choices' => array('wpa' => 'wpa', 'wpa2' => 'wpa2', 'off' => 'off')));

    $this->widgetSchema   ['passphrase'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['passphrase'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['group_rekey_interval'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['group_rekey_interval'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['strict_rekey'] = new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no')));
    $this->validatorSchema['strict_rekey'] = new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0)));

    $this->widgetSchema->setNameFormat('mode1_filters[%s]');
  }

  public function getModelName()
  {
    return 'Mode1';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'config_id' => 'ForeignKey',
      'wpa_mode' => 'Enum',
      'passphrase' => 'Text',
      'group_rekey_interval' => 'Number',
      'strict_rekey' => 'Boolean',
    ));
  }
}
