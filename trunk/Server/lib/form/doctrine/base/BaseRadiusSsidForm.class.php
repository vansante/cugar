<?php

/**
 * RadiusSsid form base class.
 *
 * @method RadiusSsid getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRadiusSsidForm extends SsidForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['retry_interval'] = new sfWidgetFormInputText();
    $this->validatorSchema['retry_interval'] = new sfValidatorInteger();

    $this->widgetSchema   ['own_ip'] = new sfWidgetFormInputText();
    $this->validatorSchema['own_ip'] = new sfValidatorString(array('max_length' => 15));

    $this->widgetSchema   ['nas_identifier'] = new sfWidgetFormInputText();
    $this->validatorSchema['nas_identifier'] = new sfValidatorString(array('max_length' => 48, 'min_length' => 1));

    $this->widgetSchema   ['radius_auth_ip'] = new sfWidgetFormInputText();
    $this->validatorSchema['radius_auth_ip'] = new sfValidatorString(array('max_length' => 15));

    $this->widgetSchema   ['radius_auth_port'] = new sfWidgetFormInputText();
    $this->validatorSchema['radius_auth_port'] = new sfValidatorInteger();

    $this->widgetSchema   ['radius_auth_shared_secret'] = new sfWidgetFormInputText();
    $this->validatorSchema['radius_auth_shared_secret'] = new sfValidatorString(array('max_length' => 255, 'min_length' => 1));

    $this->widgetSchema   ['radius_acct_ip'] = new sfWidgetFormInputText();
    $this->validatorSchema['radius_acct_ip'] = new sfValidatorString(array('max_length' => 15));

    $this->widgetSchema   ['radius_acct_port'] = new sfWidgetFormInputText();
    $this->validatorSchema['radius_acct_port'] = new sfValidatorInteger();

    $this->widgetSchema   ['radius_acct_shared_secret'] = new sfWidgetFormInputText();
    $this->validatorSchema['radius_acct_shared_secret'] = new sfValidatorString(array('max_length' => 255, 'min_length' => 1));

    $this->widgetSchema   ['radius_acct_interim_interval'] = new sfWidgetFormInputText();
    $this->validatorSchema['radius_acct_interim_interval'] = new sfValidatorInteger();

    $this->widgetSchema->setNameFormat('radius_ssid[%s]');
  }

  public function getModelName()
  {
    return 'RadiusSsid';
  }

}
