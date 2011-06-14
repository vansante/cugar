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
abstract class BaseMode3Form extends RadiusSsidForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['config_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Config'), 'add_empty' => false));
    $this->validatorSchema['config_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Config')));

    $this->widgetSchema   ['traffic_mode'] = new sfWidgetFormChoice(array('choices' => array('no_tunneling' => 'no_tunneling', 'tunnel_to_data_tunnel' => 'tunnel_to_data_tunnel', 'tunnel_to_auth_tunnel' => 'tunnel_to_auth_tunnel')));
    $this->validatorSchema['traffic_mode'] = new sfValidatorChoice(array('choices' => array(0 => 'no_tunneling', 1 => 'tunnel_to_data_tunnel', 2 => 'tunnel_to_auth_tunnel'), 'required' => false));

    $this->widgetSchema   ['vpn_auth_server'] = new sfWidgetFormInputText();
    $this->validatorSchema['vpn_auth_server'] = new sfValidatorString(array('max_length' => 255));

    $this->widgetSchema   ['vpn_auth_port'] = new sfWidgetFormInputText();
    $this->validatorSchema['vpn_auth_port'] = new sfValidatorInteger();

    $this->widgetSchema   ['vpn_auth_cipher'] = new sfWidgetFormChoice(array('choices' => array('DES-CBC' => 'DES-CBC', 'AES-128-CBC' => 'AES-128-CBC', 'AES-192-CBC' => 'AES-192-CBC', 'AES-256-CBC' => 'AES-256-CBC', 'BF-CBC' => 'BF-CBC')));
    $this->validatorSchema['vpn_auth_cipher'] = new sfValidatorChoice(array('choices' => array(0 => 'DES-CBC', 1 => 'AES-128-CBC', 2 => 'AES-192-CBC', 3 => 'AES-256-CBC', 4 => 'BF-CBC'), 'required' => false));

    $this->widgetSchema   ['vpn_auth_compression'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['vpn_auth_compression'] = new sfValidatorBoolean(array('required' => false));

    $this->widgetSchema   ['vpn_data_server'] = new sfWidgetFormInputText();
    $this->validatorSchema['vpn_data_server'] = new sfValidatorString(array('max_length' => 255, 'required' => false));

    $this->widgetSchema   ['vpn_data_port'] = new sfWidgetFormInputText();
    $this->validatorSchema['vpn_data_port'] = new sfValidatorInteger(array('required' => false));

    $this->widgetSchema   ['vpn_data_cipher'] = new sfWidgetFormChoice(array('choices' => array('DES-CBC' => 'DES-CBC', 'AES-128-CBC' => 'AES-128-CBC', 'AES-192-CBC' => 'AES-192-CBC', 'AES-256-CBC' => 'AES-256-CBC', 'BF-CBC' => 'BF-CBC')));
    $this->validatorSchema['vpn_data_cipher'] = new sfValidatorChoice(array('choices' => array(0 => 'DES-CBC', 1 => 'AES-128-CBC', 2 => 'AES-192-CBC', 3 => 'AES-256-CBC', 4 => 'BF-CBC'), 'required' => false));

    $this->widgetSchema   ['vpn_data_compression'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['vpn_data_compression'] = new sfValidatorBoolean(array('required' => false));

    $this->widgetSchema->setNameFormat('mode3[%s]');
  }

  public function getModelName()
  {
    return 'Mode3';
  }

}
