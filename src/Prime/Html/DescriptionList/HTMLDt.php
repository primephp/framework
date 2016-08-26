<?php

namespace Prime\Html\DescriptionList;

use Prime\Html\Base\HTMLElement;

/**
 * Descrição de HTMLDt
 * Cria um termo / nome na lista de descrição
 * @author Elton Luiz
 */
class HTMLDt extends HTMLElement {

    public function __construct($id = NULL) {
        parent::__construct('dt');
        if (!is_null($id)) {
            $this->setAttribute('id', $id);
        }
    }

}
