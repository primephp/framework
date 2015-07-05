<?php

namespace Prime\Bootstrap\Panel;

/**
 * Descrição de DialogError
 * @name DialogError
 * @package Prime\Bootstrap\Panel
 * @create 03/04/2014
 * @access public
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
class DialogError extends DialogInformation {

    public function __construct($message, $title = 'ATENÇÃO') {
        parent::__construct($message, $title);
    }

    public function getOutput() {
        $this->panel->addClass('panel-danger');
        $this->btnOk->setAttribute('class', 'btn btn-danger');
        return parent::getOutput();
    }

}
