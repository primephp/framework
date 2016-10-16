<?php

namespace Prime\Html\Base;

class HTMLIFrame extends HTMLElement {

    /**
     * Cria um IFrame
     * @param string $text
     */
    public function __construct($src = NULL) {
        parent::__construct("iframe");
        $this->setAttribute("width", "99%");
        //$this->setAttribute("height", "0");
        $this->setAttribute("frameborder", "0");
        $this->setAttribute("marginwidth", "0");
        $this->setAttribute("marginheight", "0");
        if (!is_null($src)) {
            $this->setAttribute("src", "$src");
        }
    }

    /**
     * Este método reescrito será usado para alterar o atributo src do HTMLIFrame.
     * Portanto deverá ser um caminho para um arquivo absoluto ou relativo.
     *
     * @param string $child
     */
    public function appendChild($child) {
        $this->setAttribute("src", $child);
    }

}
