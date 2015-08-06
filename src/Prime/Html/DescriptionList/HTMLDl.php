<?php

namespace Prime\Html\DescriptionList;

use Prime\Html\Base\HTMLElement;

/**
 * Descrição de HTMLDl
 * Cria uma tag de uma lista de descrição DL
 * @author Elton Luiz
 */
class HTMLDl extends HTMLElement
{

    public function __construct($id = NULL)
    {
        parent::__construct('dl');
        if (!is_null($id)) {
            $this->setAttribute('id', $id);
        }
    }

    public function addItem($term, $value)
    {
        parent::appendChild($term);
        parent::appendChild($value);
    }

    public function appendChild(HTMLDt $dt, HTMLDd $dd = NULL)
    {
        parent::appendChild($dt);
        if (!is_null($dd)) {
            parent::appendChild($dd);
        }
    }

}
