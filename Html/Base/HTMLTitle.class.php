<?php

namespace Prime\Html\Base;

class HTMLTitle extends HTMLElement {

//configuracao interna de dados
    /**
     *
     *
     * @param string $title
     */
    public function __construct($title = "") {
        parent::__construct("title");
        $this->appendChild($title);
    }

    /**
     * Adiciona um texto ao t�tulo
     *
     * @param string $title
     */
    public function setTitle($title) {
        $this->appendChild($title);
    }

}

