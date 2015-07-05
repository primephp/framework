<?php

namespace Prime\Bootstrap\Row;

use Prime\Business\IStaticCreate,
    Prime\Html\Base\HTMLDiv;

/**
 * Descrição de HtmlRow
 * @name HtmlRow
 * @package Prime\Bootstrap\Row
 * @create 23/03/2014
 * @access public
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
class HtmlRow extends HTMLDiv implements IStaticCreate {

    public function __construct($nameId = null) {
        parent::__construct($nameId);
        parent::setAttribute('class', 'row');
    }

    public static function create($nameId = null) {
        return new HtmlRow($nameId);
    }

}
