<?php

namespace Prime\Html\Base;

class HTMLParagraph extends HTMLElement {

//configuracao interna de dados
    /**
     * Enter description here...
     *
     * @param string $text
     */
    public function __construct($text = "") {
        parent::__construct("p");
        $this->appendChild($text);
    }

    /**
     * Adiciona um texto ao par�grafo
     *
     * @param string $text
     */
    public function appendText($text) {
        $this->appendChild($text);
    }

    /**
     * Configura o alinhamento horizontal do parágrafo.
     * left, center,right
     * @param mixed $align
     */
    public function setAlignment($align) {
        if (is_numeric($align)) {
            $al = array("left", "center", "right");
            $align = $al[$align];
        }
        $this->align = $align;
    }

}

