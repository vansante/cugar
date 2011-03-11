<?php

/**
 * Mode3 filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMode3FormFilter extends RadiusSsidFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['config_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Config'), 'add_empty' => true));
    $this->validatorSchema['config_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Config'), 'column' => 'id'));

    $this->widgetSchema   ['vpn_auth_server'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['vpn_auth_server'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['vpn_auth_port'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['vpn_auth_port'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['vpn_auth_cipher'] = new sfWidgetFormChoice(array('choices' => array('' => '', 'DES-CBC' => 'DES-CBC', 'AES-128-CBC' => 'AES-128-CBC', 'AES-192-CBC' => 'AES-192-CBC', 'AES-256-CBC' => 'AES-256-CBC', 'BF-CBC' => 'BF-CBC')));
    $this->validatorSchema['vpn_auth_cipher'] = new sfValidatorChoice(array('required' => false, 'choices' => array('DES-CBC' => 'DES-CBC', 'AES-128-CBC' => 'AES-128-CBC', 'AES-192-CBC' => 'AES-192-CBC', 'AES-256-CBC' => 'AES-256-CBC', 'BF-CBC' => 'BF-CBC')));

    $this->widgetSchema   ['vpn_auth_compression'] = new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no')));
    $this->validatorSchema['vpn_auth_compression'] = new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0)));

    $this->widgetSchema   ['vpn_data_server'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['vpn_data_server'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['vpn_data_port'] = new sfWidgetFormFilterInput();
    $this->validatorSchema['vpn_data_port'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['vpn_data_cipher'] = new sfWidgetFormChoice(array('choices' => array('' => '', 'DES-CBC' => 'DES-CBC', 'AES-128-CBC' => 'AES-128-CBC', 'AES-192-CBC' => 'AES-192-CBC', 'AES-256-CBC' => 'AES-256-CBC', 'BF-CBC' => 'BF-CBC')));
    $this->validatorSchema['vpn_data_cipher'] = new sfValidatorChoice(array('required' => false, 'choices' => array('DES-CBC' => 'DES-CBC', 'AES-128-CBC' => 'AES-128-CBC', 'AES-192-CBC' => 'AES-192-CBC', 'AES-256-CBC' => 'AES-256-CBC', 'BF-CBC' => 'BF-CBC')));

    $this->widgetSchema   ['vpn_data_compression'] = new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no')));
    $this->validatorSchema['vpn_data_compression'] = new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0)));

    $this->widgetSchema->setNameFormat('mode3_filters[%s]');
  }

  public function getModelName()
  {
    return 'Mode3';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'config_id' => 'ForeignKey',
      'vpn_auth_server' => 'Text',
      'vpn_auth_port' => 'Number',
      'vpn_auth_cipher' => 'Enum',
      'vpn_auth_compression' => 'Boolean',
      'vpn_data_server' => 'Text',
      'vpn_data_port' => 'Number',
      'vpn_data_cipher' => 'Enum',
      'vpn_data_compression' => 'Boolean',
    ));
  }
}
