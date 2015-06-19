<?php

namespace Prime\DataTypes;

/**
 * Descrição da Classe JsonObject
 * @package Prime\DataTypes
 * @author TomSailor
 * @since 06/07/2011
 */
class TJson {

    private $childs;

    public function __construct() {
        $this->childs = array();
    }

    public function insertObj() {
        $obj = new JsonObject();
    }

}

