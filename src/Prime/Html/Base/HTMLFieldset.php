<?php

namespace Prime\Html\Base;

/**
 * Descrição de HTMLFieldset
 *
 * @author tom
 */
class HTMLFieldset extends HTMLElement
{

    /**
     * Armazena o objeto HTMLLegend que define a legenda
     * do Fieldset
     * @var HTMLLegend 
     */
    private $_legend = NULL;

    public function __construct($content = NULL)
    {
        parent::__construct('fieldset');

        if (!is_null($content)) {
            parent::appendChild($content);
        }
    }

    public function setLegend($legend)
    {
        $this->_legend = new HTMLLegend($legend);

        return $this->_legend;
    }

    public function getOutput()
    {
        if (!is_null($this->_legend)) {
            $this->prependChild($this->_legend);
        }
        return parent::getOutput();
    }

}
