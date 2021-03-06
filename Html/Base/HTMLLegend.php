<?php

namespace Prime\Html\Base;

/**
 * Descrição de HTMLLegend
 *
 * @author Elton Luiz
 */
class HTMLLegend extends HTMLElement
{

    public function __construct($text = NULL)
    {
        parent::__construct('legend');

        if (!is_null($text)) {
            parent::appendChild($text);
        }
    }

}
