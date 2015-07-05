<?php

namespace Prime\Html\Input;

/**
 * Descrição de HTMLInputEmail
 *
 * @author Elton Luiz
 */
class HTMLInputEmail extends HTMLInput {

    public function __construct($name) {
        parent::__construct();
        $this->element->name = $name;
        $this->element->id = $name;
        $this->element->type = 'email';
    }

}
