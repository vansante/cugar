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

    $this->widgetSchema->setNameFormat('mode1[%s]');
  }

  public function getModelName()
  {
    return 'Mode1';
  }

}
