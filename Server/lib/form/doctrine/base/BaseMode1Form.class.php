<?php

/**
 * Mode1 form base class.
 *
 * @method Mode1 getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMode1Form extends SsidForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['config_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Config'), 'add_empty' => false));
    $this->validatorSchema['config_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Config')));

    $this->widgetSchema   ['wpa_mode'] = new sfWidgetFormChoice(array('choices' => array('wpa' => 'wpa', 'wpa2' => 'wpa2', 'off' => 'off')));
    $this->validatorSchema['wpa_mode'] = new sfValidatorChoice(array('choices' => array(0 => 'wpa', 1 => 'wpa2', 2 => 'off'), 'required' => false));

    $this->widgetSchema   ['passphrase'] = new sfWidgetFormInputText();
    $this->validatorSchema['passphrase'] = new sfValidatorString(array('max_length' => 64, 'min_length' => 8, 'required' => false));

    $this->widgetSchema   ['group_rekey_interval'] = new sfWidgetFormInputText();
    $this->validatorSchema['group_rekey_interval'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['strict_rekey'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['strict_rekey'] = new sfValidatorBoolean(array('required' => false));

    $this->widgetSchema->setNameFormat('mode1[%s]');
  }

  public function getModelName()
  {
    return 'Mode1';
  }

}
