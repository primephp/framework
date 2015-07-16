<?php

namespace Prime\Html\Base;

class HTMLSpan extends HTMLElement {

//configuracao interna de dados
    /**
     * Enter description here...
     *
     * @param string $text
     */
    public function __construct($content = "") {
        parent::__construct("span");
        parent::appendChild($content);
    }

}

