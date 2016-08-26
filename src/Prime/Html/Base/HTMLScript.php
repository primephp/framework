<?php

namespace Prime\Html\Base;

class HTMLScript extends HTMLElement {
//configuracao interna de dados

    /**
     *
     * @param script $src
     */
    public function __construct($src = null) {
        parent::__construct("script");
        $this->type = "text/javascript";
        //$this->language="javascript";
        $this->appendChild(" ");
        if (!is_null($src)) {
            $this->src = $src;
        }
    }

}
