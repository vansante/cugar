<?php

/**
 * RadiusSsid filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseRadiusSsidFormFilter extends SsidFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['retry_interval'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['retry_interval'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['own_ip'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['own_ip'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['nas_identifier'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['nas_identifier'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['radius_auth_ip'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['radius_auth_ip'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['radius_auth_port'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['radius_auth_port'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['radius_auth_shared_secret'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['radius_auth_shared_secret'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['radius_acct_ip'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['radius_acct_ip'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['radius_acct_port'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['radius_acct_port'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema   ['radius_acct_shared_secret'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['radius_acct_shared_secret'] = new sfValidatorPass(array('required' => false));

    $this->widgetSchema   ['radius_acct_interim_interval'] = new sfWidgetFormFilterInput(array('with_empty' => false));
    $this->validatorSchema['radius_acct_interim_interval'] = new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false)));

    $this->widgetSchema->setNameFormat('radius_ssid_filters[%s]');
  }

  public function getModelName()
  {
    return 'RadiusSsid';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'retry_interval' => 'Number',
      'own_ip' => 'Text',
      'nas_identifier' => 'Text',
      'radius_auth_ip' => 'Text',
      'radius_auth_port' => 'Number',
      'radius_auth_shared_secret' => 'Text',
      'radius_acct_ip' => 'Text',
      'radius_acct_port' => 'Number',
      'radius_acct_shared_secret' => 'Text',
      'radius_acct_interim_interval' => 'Number',
    ));
  }
}
