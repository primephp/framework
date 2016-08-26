<?php

namespace Prime\Html\Table;

use Prime\Html\Base\HTMLElement;

class HTMLTable extends HTMLElement {

    /**
     * Instancia uma nova tabela
     * 
     */
    public function __construct() {
        parent::__construct('table');
    }

    /**
     *
     * Instancia um linha e armazena na tabela para ser
     * manipulada.
     *
     * @return HTMLTableRow
     *
     */
    public function insertRow() {
        $row = new HTMLTableRow();
        //armazena no array de linhas
        parent::appendChild($row);
        return $row;
    }

}
