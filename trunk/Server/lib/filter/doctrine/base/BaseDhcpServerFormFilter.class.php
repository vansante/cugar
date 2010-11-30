<?php

/**
 * DhcpServer filter form base class.
 *
 * @package    sf_sandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDhcpServerFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'mode3_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Mode3'), 'add_empty' => true)),
      'ip'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'mode3_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Mode3'), 'column' => 'id')),
      'ip'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('dhcp_server_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'DhcpServer';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'mode3_id' => 'ForeignKey',
      'ip'       => 'Text',
    );
  }
}
