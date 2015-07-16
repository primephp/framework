<?php

namespace Prime\Bootstrap\Widget;

use Prime\Html\Base\HTMLSpan;

/**
 * Descrição de Badge
 * @name Badge
 * @package  Prime\Bootstrap\Widget
 * @create 16/08/2014
 * @access public
 * @author Tom Sailor <contato@eltonluiz.com.br>
 */
class Badge extends HTMLSpan {

    public function __construct($content = NULL) {
        parent::__construct('');
        parent::addClass('badge');
        parent::appendChild($content);
    }

    /**
     * Retorna uma instância de Badge
     * @param mixed $content
     * @return \Prime\Bootstrap\Widget\Badge
     */
    public static function create($content = NULL){
        return new Badge($content);
    }
}
