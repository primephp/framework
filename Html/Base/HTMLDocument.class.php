<?php

namespace Prime\Html\Base;

/**
 * Classe que representa todo o documento raiz de um documento HTML
 *
 */
class HTMLDocument extends HTMLElement {

    public function HTMLDocument() {
        parent::__construct("html");
    }

}

