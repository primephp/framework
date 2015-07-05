<?php

namespace Prime\Html\Table;

use Prime\Html\Base\HTMLElement;

class HTMLTableCell extends HTMLElement {

    public function __construct($value) {
        parent::__construct('td');
        parent::appendChild($value);
    }

}

