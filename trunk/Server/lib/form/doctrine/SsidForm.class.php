<?php

/**
 * Ssid form.
 *
 * @package    sf_sandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SsidForm extends BaseSsidForm {

    public function configure() {

        $ssid = $this->getObject();

        if ($ssid->mode == 2) {
            $mode2 = Mode2Table::getInstance()->findOneBy('ssid_id', $ssid->id);

            if (!$mode2) {
                $mode2 = new Mode2();
                $mode2->Ssid = $ssid;
            }

            $mode2form = new Mode2Form($mode2);

            $this->embedForm('mode2', $mode2form);

        } else if ($ssid->mode == 3) {
            $mode3 = Mode3Table::getInstance()->findOneBy('ssid_id', $ssid->id);
            if ($mode3) {
                $mode3 = new Mode3();
                $mode3->Ssid = $ssid;
            }

            $mode3form = new Mode3Form($mode3);

            $this->embedForm('mode3', $mode3form);

        }
    }

}
