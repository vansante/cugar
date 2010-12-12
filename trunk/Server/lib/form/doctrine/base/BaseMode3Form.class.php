<?php

/**
 * Mode3 form base class.
 *
 * @method Mode3 getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMode3Form extends SsidForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['config_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Config'), 'add_empty' => false));
    $this->validatorSchema['config_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Config')));

    $this->widgetSchema   ['retry_interval'] = new sfWidgetFormInputText();
    $this->validatorSchema['retry_interval'] = new sfValidatorInteger();

    $this->widgetSchema   ['own_ip'] = new sfWidgetFormInputText();
    $this->validatorSchema['own_ip'] = new sfValidatorString(array('max_length' => 15));

    $this->widgetSchema   ['nas_identifier'] = new sfWidgetFormInputText();
    $this->validatorSchema['nas_identifier'] = new sfValidatorString(array('max_length' => 48, 'min_length' => 1));

    $this->widgetSchema   ['hw_interface'] = new sfWidgetFormInputText();
    $this->validatorSchema['hw_interface'] = new sfValidatorString(array('max_length' => 5, 'min_length' => 3));

    $this->widgetSchema   ['radius_auth_ip'] = new sfWidgetFormInputText();
    $this->validatorSchema['radius_auth_ip'] = new sfValidatorString(array('max_length' => 15));

    $this->widgetSchema   ['radius_auth_port'] = new sfWidgetFormInputText();
    $this->validatorSchema['radius_auth_port'] = new sfValidatorInteger();

    $this->widgetSchema   ['radius_auth_shared_secret'] = new sfWidgetFormInputText();
    $this->validatorSchema['radius_auth_shared_secret'] = new sfValidatorString(array('max_length' => 255, 'min_length' => 1));

    $this->widgetSchema   ['radius_auth_interim_interval'] = new sfWidgetFormInputText();
    $this->validatorSchema['radius_auth_interim_interval'] = new sfValidatorInteger();

    $this->widgetSchema   ['radius_acct_ip'] = new sfWidgetFormInputText();
    $this->validatorSchema['radius_acct_ip'] = new sfValidatorString(array('max_length' => 15));

    $this->widgetSchema   ['radius_acct_port'] = new sfWidgetFormInputText();
    $this->validatorSchema['radius_acct_port'] = new sfValidatorInteger();

    $this->widgetSchema   ['radius_acct_shared_secret'] = new sfWidgetFormInputText();
    $this->validatorSchema['radius_acct_shared_secret'] = new sfValidatorString(array('max_length' => 255, 'min_length' => 1));

    $this->widgetSchema   ['radius_acct_interim_interval'] = new sfWidgetFormInputText();
    $this->validatorSchema['radius_acct_interim_interval'] = new sfValidatorInteger();

    $this->widgetSchema   ['vpn_auth_server'] = new sfWidgetFormInputText();
    $this->validatorSchema['vpn_auth_server'] = new sfValidatorString(array('max_length' => 255, 'min_length' => 4));

    $this->widgetSchema   ['vpn_auth_port'] = new sfWidgetFormInputText();
    $this->validatorSchema['vpn_auth_port'] = new sfValidatorInteger();

    $this->widgetSchema   ['vpn_auth_cipher'] = new sfWidgetFormChoice(array('choices' => array('DES-CBC' => 'DES-CBC', 'AES-128-CBC' => 'AES-128-CBC', 'AES-192-CBC' => 'AES-192-CBC', 'AES-256-CBC' => 'AES-256-CBC', 'BF-CBC' => 'BF-CBC')));
    $this->validatorSchema['vpn_auth_cipher'] = new sfValidatorChoice(array('choices' => array(0 => 'DES-CBC', 1 => 'AES-128-CBC', 2 => 'AES-192-CBC', 3 => 'AES-256-CBC', 4 => 'BF-CBC'), 'required' => false));

    $this->widgetSchema   ['vpn_auth_compression'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['vpn_auth_compression'] = new sfValidatorBoolean();

    $this->widgetSchema   ['vpn_data_server'] = new sfWidgetFormInputText();
    $this->validatorSchema['vpn_data_server'] = new sfValidatorString(array('max_length' => 255, 'min_length' => 4));

    $this->widgetSchema   ['vpn_data_port'] = new sfWidgetFormInputText();
    $this->validatorSchema['vpn_data_port'] = new sfValidatorInteger();

    $this->widgetSchema   ['vpn_data_cipher'] = new sfWidgetFormChoice(array('choices' => array('DES-CBC' => 'DES-CBC', 'AES-128-CBC' => 'AES-128-CBC', 'AES-192-CBC' => 'AES-192-CBC', 'AES-256-CBC' => 'AES-256-CBC', 'BF-CBC' => 'BF-CBC')));
    $this->validatorSchema['vpn_data_cipher'] = new sfValidatorChoice(array('choices' => array(0 => 'DES-CBC', 1 => 'AES-128-CBC', 2 => 'AES-192-CBC', 3 => 'AES-256-CBC', 4 => 'BF-CBC'), 'required' => false));

    $this->widgetSchema   ['vpn_data_compression'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['vpn_data_compression'] = new sfValidatorBoolean();

    $this->widgetSchema->setNameFormat('mode3[%s]');
  }

  public function getModelName()
  {
    return 'Mode3';
  }

}
