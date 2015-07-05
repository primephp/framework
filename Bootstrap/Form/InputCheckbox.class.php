<?php

namespace Prime\Bootstrap\Form;

use Prime\Html\Input\IHtmlInputPostLabeled;

/**
 * Descrição de Checkbox
 * @name Checkbox
 * @package Prime\Bootstrap\Form
 * @create 31/03/2014
 * @access public
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
class InputCheckbox extends Input implements IHtmlInputPostLabeled {

    public function __construct($id) {
        parent::__construct();
        $this->setAttribute('type', 'checkbox');
        $this->setAttribute('id', $id);
        $this->setAttribute('name', $id);
        //$this->addCSSClass('form-control');
    }

    /**
     * Configura o estado bistate do componente CheckBox de
     * Formulário HTML;
     *
     * @param boolean $bool
     */
    public function isChecked($bool = FALSE) {
        if (is_bool($bool) && $bool == TRUE) {
            $this->element->setAttribute('checked', 'checked');
        }
    }

}
