<?php

namespace Prime\Bootstrap\Panel;

/**
 * Descrição de DialogWarning
 * @name DialogWarning
 * @package Prime\Bootstrap\Panel
 * @create 04/04/2014
 * @access public
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
class DialogWarning extends DialogInformation {

    public function getOutput() {
        $this->btnOk->setAttribute('class', 'btn btn-warning');
        $this->panel->addClass('panel-warning');
        return parent::getOutput();
    }

}
