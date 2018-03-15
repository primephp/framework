<?php

namespace Prime\Html\Base;

/**
 * Descrição da Classe HTMLDiv
 * 
 * @author Elton Luiz
 */
class HTMLDiv extends HTMLElement
{

    public function __construct($nameId = null)
    {
        parent::__construct('div');

        if (!is_null($nameId)) {
            $this->id = $nameId;
            $this->name = $nameId;
        }
    }

}
