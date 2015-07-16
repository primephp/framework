<?php

namespace Prime\Bootstrap\Timeline;

use Prime\Html\Base\HTMLElement;

/**
 * Descrição de Timeline
 * @name Timeline
 * @package Prime\Bootstrap\Timeline;
 * @version 1.0
 * @create 16/10/2014
 * @access public
 * @author tom
 */
class Timeline extends HTMLElement {

    public function __construct($id = NULL) {
        parent::__construct('ul');
        if (!is_null($id)) {
            parent::setAttribute('id', $id);
        }
        parent::addClass('timeline');
    }

    public function appendChild($item) {
        parent::appendChild($item);
    }

}
