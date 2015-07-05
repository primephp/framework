<?php

namespace Prime\Bootstrap\Widget;

use Prime\Html\Base\HTMLSpan;

/**
 * Descrição de Glyphicon
 * @name Glyphicon
 * @package Prime\Bootstrap\Widget
 * @create 04/05/2014
 * @access public
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
class Glyphicon extends HTMLSpan {

    public function __construct($iconName) {
        parent::__construct('');
        parent::addClass('glyphicon glyphicon-' . $iconName);
    }

    public static function create($iconName) {
        return new Glyphicon($iconName);
    }

}
