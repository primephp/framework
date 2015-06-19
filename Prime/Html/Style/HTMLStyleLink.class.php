<?php

namespace Prime\Html\Style;

use Prime\Html\Base\HTMLElement;

class HTMLStyleLink extends HTMLElement {
//configuracao interna de dados

    /**
     *
     * @param string $href
     */
    public function __construct($href = null) {
        parent::__construct("link");
        $this->rel = "stylesheet";
        $this->type = "text/css";
        if (!is_null($href)) {
            $this->href = $href;
        }
    }

}

