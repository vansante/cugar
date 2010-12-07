<?php

/**
 * Mode3 filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMode3FormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ssid_id'                      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ssid'), 'add_empty' => true)),
      'retry_interval'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'own_ip'                       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nas_identifier'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dhcprelay_ip'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'hw_interface'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'radius_auth_ip'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'radius_auth_port'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'radius_auth_shared_secret'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'radius_auth_interim_interval' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'radius_acct_ip'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'radius_acct_port'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'radius_acct_shared_secret'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'radius_acct_interim_interval' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'vpn_auth_server'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'vpn_auth_port'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'vpn_auth_cipher'              => new sfWidgetFormChoice(array('choices' => array('' => '', 'DES-CBC' => 'DES-CBC', 'AES-128-CBC' => 'AES-128-CBC', 'AES-192-CBC' => 'AES-192-CBC', 'AES-256-CBC' => 'AES-256-CBC', 'BF-CBC' => 'BF-CBC'))),
      'vpn_auth_compression'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'vpn_data_port'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'vpn_data_cipher'              => new sfWidgetFormChoice(array('choices' => array('' => '', 'DES-CBC' => 'DES-CBC', 'AES-128-CBC' => 'AES-128-CBC', 'AES-192-CBC' => 'AES-192-CBC', 'AES-256-CBC' => 'AES-256-CBC', 'BF-CBC' => 'BF-CBC'))),
      'vpn_data_compression'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'ssid_id'                      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Ssid'), 'column' => 'id')),
      'retry_interval'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'own_ip'                       => new sfValidatorPass(array('required' => false)),
      'nas_identifier'               => new sfValidatorPass(array('required' => false)),
      'dhcprelay_ip'                 => new sfValidatorPass(array('required' => false)),
      'hw_interface'                 => new sfValidatorPass(array('required' => false)),
      'radius_auth_ip'               => new sfValidatorPass(array('required' => false)),
      'radius_auth_port'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'radius_auth_shared_secret'    => new sfValidatorPass(array('required' => false)),
      'radius_auth_interim_interval' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'radius_acct_ip'               => new sfValidatorPass(array('required' => false)),
      'radius_acct_port'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'radius_acct_shared_secret'    => new sfValidatorPass(array('required' => false)),
      'radius_acct_interim_interval' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'vpn_auth_server'              => new sfValidatorPass(array('required' => false)),
      'vpn_auth_port'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'vpn_auth_cipher'              => new sfValidatorChoice(array('required' => false, 'choices' => array('DES-CBC' => 'DES-CBC', 'AES-128-CBC' => 'AES-128-CBC', 'AES-192-CBC' => 'AES-192-CBC', 'AES-256-CBC' => 'AES-256-CBC', 'BF-CBC' => 'BF-CBC'))),
      'vpn_auth_compression'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'vpn_data_port'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'vpn_data_cipher'              => new sfValidatorChoice(array('required' => false, 'choices' => array('DES-CBC' => 'DES-CBC', 'AES-128-CBC' => 'AES-128-CBC', 'AES-192-CBC' => 'AES-192-CBC', 'AES-256-CBC' => 'AES-256-CBC', 'BF-CBC' => 'BF-CBC'))),
      'vpn_data_compression'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('mode3_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Mode3';
  }

  public function getFields()
  {
    return array(
      'id'                           => 'Number',
      'ssid_id'                      => 'ForeignKey',
      'retry_interval'               => 'Number',
      'own_ip'                       => 'Text',
      'nas_identifier'               => 'Text',
      'dhcprelay_ip'                 => 'Text',
      'hw_interface'                 => 'Text',
      'radius_auth_ip'               => 'Text',
      'radius_auth_port'             => 'Number',
      'radius_auth_shared_secret'    => 'Text',
      'radius_auth_interim_interval' => 'Number',
      'radius_acct_ip'               => 'Text',
      'radius_acct_port'             => 'Number',
      'radius_acct_shared_secret'    => 'Text',
      'radius_acct_interim_interval' => 'Number',
      'vpn_auth_server'              => 'Text',
      'vpn_auth_port'                => 'Number',
      'vpn_auth_cipher'              => 'Enum',
      'vpn_auth_compression'         => 'Boolean',
      'vpn_data_port'                => 'Number',
      'vpn_data_cipher'              => 'Enum',
      'vpn_data_compression'         => 'Boolean',
    );
  }
}
