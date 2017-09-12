<?php

namespace Prime\Html\Input;

/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL - 2008
 *
 *
 * Concluida
 *  
 */
class HTMLInputText extends HTMLInput {

    public function __construct($name) {
        parent::__construct();
        $this->element->name = $name;
        $this->element->id = $name;
        $this->element->type = 'text';
    }

}
