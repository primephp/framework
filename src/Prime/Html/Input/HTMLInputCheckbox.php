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
class HTMLInputCheckbox extends HTMLInput implements IHtmlInputPostLabeled {

    private $state;

    public function __construct($name) {
        parent::__construct();
        $this->element->type = "checkbox";
        $this->element->name = $name;
        $this->element->id = $name;
    }

    /**
     * Configura o estado bistate do componente CheckBox de
     * Formulário HTML;
     *
     * @param boolean $bool
     */
    public function isChecked($bool = FALSE) {
        if (is_bool($bool) && $bool == TRUE) {
            $this->element->checked = "checked ";
        }
    }

}
