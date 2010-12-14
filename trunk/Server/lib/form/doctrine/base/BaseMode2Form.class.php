<?php

/**
 * Mode2 form base class.
 *
 * @method Mode2 getObject() Returns the current form's model object
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMode2Form extends RadiusSsidForm {

    protected function setupInheritance() {
        parent::setupInheritance();

        $this->widgetSchema ['config_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Config'), 'add_empty' => false));
        $this->validatorSchema['config_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Config')));

        $this->widgetSchema ['file_name'] = new sfWidgetFormInputText();
        $this->validatorSchema['file_name'] = new sfValidatorString(array('max_length' => 255, 'min_length' => 4));

        $this->widgetSchema->setNameFormat('mode2[%s]');
    }

    public function getModelName() {
        return 'Mode2';
    }

}
