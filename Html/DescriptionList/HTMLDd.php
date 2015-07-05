<?php

namespace Prime\Html\DescriptionList;

use Prime\Html\Base\HTMLElement;

/**
 * Descrição de HTMLDd
 *
 * @author Elton Luiz
 */
class HTMLDd extends HTMLElement {

    public function __construct($id = NULL) {
        parent::__construct('dd');
        if (!is_null($id)) {
            $this->setAttribute('id', $id);
        }
    }

}
