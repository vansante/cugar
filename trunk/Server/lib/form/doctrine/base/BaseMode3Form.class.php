<?php

/**
 * Mode3 form base class.
 *
 * @method Mode3 getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMode3Form extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                             => new sfWidgetFormInputHidden(),
      'ssid_id'                        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ssid'), 'add_empty' => true)),
      'retry_interval'                 => new sfWidgetFormInputText(),
      'own_ip'                         => new sfWidgetFormInputText(),
      'nas_identifier'                 => new sfWidgetFormInputText(),
      'dhcprelay_ip'                   => new sfWidgetFormInputText(),
      'hw_interface'                   => new sfWidgetFormInputText(),
      'radius_auth_ip'                 => new sfWidgetFormInputText(),
      'radius_auth_port'               => new sfWidgetFormInputText(),
      'radius_auth_shared_secret'      => new sfWidgetFormInputText(),
      'radius_auth_interim_interval'   => new sfWidgetFormInputText(),
      'radius_acct_auth_ip'            => new sfWidgetFormInputText(),
      'radius_acct_auth_port'          => new sfWidgetFormInputText(),
      'radius_acct_auth_shared_secret' => new sfWidgetFormInputText(),
      'radius_acct_interim_interval'   => new sfWidgetFormInputText(),
      'vpn_auth_server'                => new sfWidgetFormInputText(),
      'vpn_auth_port'                  => new sfWidgetFormInputText(),
      'vpn_auth_cipher'                => new sfWidgetFormChoice(array('choices' => array('DES-CBC' => 'DES-CBC', 'AES-128-CBC' => 'AES-128-CBC', 'AES-192-CBC' => 'AES-192-CBC', 'AES-256-CBC' => 'AES-256-CBC', 'BF-CBC' => 'BF-CBC'))),
      'vpn_auth_compression'           => new sfWidgetFormInputCheckbox(),
      'vpn_data_port'                  => new sfWidgetFormInputText(),
      'vpn_data_cipher'                => new sfWidgetFormChoice(array('choices' => array('DES-CBC' => 'DES-CBC', 'AES-128-CBC' => 'AES-128-CBC', 'AES-192-CBC' => 'AES-192-CBC', 'AES-256-CBC' => 'AES-256-CBC', 'BF-CBC' => 'BF-CBC'))),
      'vpn_data_compression'           => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ssid_id'                        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Ssid'), 'required' => false)),
      'retry_interval'                 => new sfValidatorInteger(),
      'own_ip'                         => new sfValidatorString(array('max_length' => 15)),
      'nas_identifier'                 => new sfValidatorString(array('max_length' => 48, 'min_length' => 1)),
      'dhcprelay_ip'                   => new sfValidatorString(array('max_length' => 15)),
      'hw_interface'                   => new sfValidatorString(array('max_length' => 5, 'min_length' => 3)),
      'radius_auth_ip'                 => new sfValidatorString(array('max_length' => 15)),
      'radius_auth_port'               => new sfValidatorInteger(),
      'radius_auth_shared_secret'      => new sfValidatorString(array('max_length' => 255, 'min_length' => 1)),
      'radius_auth_interim_interval'   => new sfValidatorInteger(),
      'radius_acct_auth_ip'            => new sfValidatorString(array('max_length' => 15)),
      'radius_acct_auth_port'          => new sfValidatorInteger(),
      'radius_acct_auth_shared_secret' => new sfValidatorString(array('max_length' => 255, 'min_length' => 1)),
      'radius_acct_interim_interval'   => new sfValidatorInteger(),
      'vpn_auth_server'                => new sfValidatorString(array('max_length' => 255, 'min_length' => 4)),
      'vpn_auth_port'                  => new sfValidatorInteger(),
      'vpn_auth_cipher'                => new sfValidatorChoice(array('choices' => array(0 => 'DES-CBC', 1 => 'AES-128-CBC', 2 => 'AES-192-CBC', 3 => 'AES-256-CBC', 4 => 'BF-CBC'))),
      'vpn_auth_compression'           => new sfValidatorBoolean(),
      'vpn_data_port'                  => new sfValidatorInteger(),
      'vpn_data_cipher'                => new sfValidatorChoice(array('choices' => array(0 => 'DES-CBC', 1 => 'AES-128-CBC', 2 => 'AES-192-CBC', 3 => 'AES-256-CBC', 4 => 'BF-CBC'))),
      'vpn_data_compression'           => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('mode3[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Mode3';
  }

}
