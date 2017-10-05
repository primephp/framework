<?php

namespace Prime\Html\Table;

use Prime\Html\Base\HTMLElement;

class HTMLTableRow extends HTMLElement
{

    //instancia uma nova linha
    public function __construct()
    {
        parent::__construct('tr');
    }

    /**
     * Agrega um novo elemento (HTMLTableCell) � linha
     *
     * @return HTMLTableCell
     */
    public function insertCell($value = NULL)
    {
        $cell = new HTMLTableCell($value);
        parent::appendChild($cell);
        return $cell;
    }

}
