<?php

/**
 * Configuration form base class.
 *
 * @method Configuration getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseConfigurationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputText(),
      'channel'       => new sfWidgetFormInputText(),
      'wireless_mode' => new sfWidgetFormChoice(
Notice: Undefined index:  values in D:\webdir\cugar-server\lib\vendor\symfony\lib\plugins\sfDoctrinePlugin\lib\generator\sfDoctrineColumn.class.php on line 324

Notice: Undefined index:  values in D:\webdir\cugar-server\lib\vendor\symfony\lib\plugins\sfDoctrinePlugin\lib\generator\sfDoctrineColumn.class.php on line 324

Warning: array_combine() expects parameter 1 to be array, null given in D:\webdir\cugar-server\lib\vendor\symfony\lib\plugins\sfDoctrinePlugin\lib\generator\sfDoctrineFormGenerator.class.php on line 348
array('choices' => NULL)),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorInteger(array('required' => false)),
      'channel'       => new sfValidatorPass(array('required' => false)),
      'wireless_mode' => new sfValidatorChoice(
Notice: Undefined index:  values in D:\webdir\cugar-server\lib\vendor\symfony\lib\plugins\sfDoctrinePlugin\lib\generator\sfDoctrineColumn.class.php on line 324
array('choices' => NULL, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('configuration[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Configuration';
  }

}
