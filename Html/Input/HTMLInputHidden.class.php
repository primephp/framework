<?php

namespace Prime\Html\Input;

class HTMLInputHidden extends HTMLInput {

    public function __construct($name) {
        parent::__construct();
        $this->element->name = $name;
        $this->element->id = $name;
        $this->element->type = 'hidden';
    }

}

