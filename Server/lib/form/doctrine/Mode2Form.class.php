<?php

/**
 * Mode2 form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Mode2Form extends BaseMode2Form {

    public function configure() {
        parent::configure();

        unset($this['file_name']);

        $this->setWidget('portal_file', new sfWidgetFormInputFile());
        $this->setValidator('portal_file', new sfValidatorFile(array(
            'required' => false,
            'mime_categories' => array('application'),
            'mime_types' => array('application/x-tar', 'application/gzip', 'application/x-gzip', 'application/bzip', 'application/bzip2', 'application/bz2')
        )));

        $this->widgetSchema->setLabels(array(
            'portal_file' => 'Captive portal webpage (in tar.gz file)',
        ));
    }

    protected function doSave($con = null) {
        if (null === $con) {
            $con = $this->getConnection();
        }

        $values = $this->values;
        unset($values['portal_file']);

        $this->updateObject($values);

        $file = $this->getValue('portal_file');
        if ($file) {
            $mode2 = $this->getObject();
            $filename = substr(sha1('portal_' . $mode2->id), 0, 20);
            $extension = $file->getExtension($file->getOriginalExtension());
            $file->save(sfConfig::get('sf_upload_dir') . '/portal/' . $filename . $extension);

            $mode2->file_name = $filename . $extension;
        }
        
        $this->getObject()->save($con);

        // embedded forms
        $this->saveEmbeddedForms($con);
    }
}
