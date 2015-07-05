<?php

namespace Prime\Html\Base;

/**
 * Descrição de HTMLMeta
 * Classe para manipulação de tag HTML
 * META
 * @author TomSailor
 */
class HTMLMeta extends HTMLElement {

    /**
     * Método Construtor
     * @param string $name nome para o atribute name
     * da tag META
     */
    function __construct($name = null) {
        parent::__construct("meta");
        if ($name) {
            $this->setAttribute("name", $name);
        }
    }

    /**
     * Método setContent
     * @param string $content conteúdo do atributo content da tag META
     * 
     */
    function setContent($content) {
        $this->setAttribute("content", $content);
    }

    /**
     * Métod setMetaAttribute
     * Define um atributo e seu valor para a tag META
     * @param string $metaName nome do atributo da tag META
     * @param string $value valor do atributo
     */
    function setMetaAttibute($metaName, $value) {
        $this->setAttribute($metaName, $value);
    }

}


