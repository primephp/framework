<?php

namespace Prime\Bootstrap\Timeline;

use Prime\Html\Base\HTMLElement;

/**
 * Descrição de TimelineAbstractItem
 * @name TimelineAbstractItem
 * @package Prime\Bootstrap\Timeline;
 * @version 1.0
 * @create 16/10/2014
 * @access public
 * @author tom
 */
abstract class TimelineAbstractItem extends HTMLElement{

    public function __construct($id = NULL) {
        parent::__construct('li');
        if (!is_null($id)) {
            parent::setAttribute('id', $id);
        }
    }
}
