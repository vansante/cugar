<?php

/**
 * Mode1 filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedInheritanceTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMode1FormFilter extends SsidFormFilter
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema   ['config_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Config'), 'add_empty' => true));
    $this->validatorSchema['config_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Config'), 'column' => 'id'));

    $this->widgetSchema->setNameFormat('mode1_filters[%s]');
  }

  public function getModelName()
  {
    return 'Mode1';
  }

  public function getFields()
  {
    return array_merge(parent::getFields(), array(
      'config_id' => 'ForeignKey',
    ));
  }
}
