<?php

namespace Prime\Html\Input;

/**
 * TODO : verificar metodo e testar estado interno
 *
 */
class HTMLInputRadio extends HTMLInput implements IHtmlInputPostLabeled {

    /**
     * Cria um elemento HTMLInputRadio, passando para ele um nome, sendo que
     * diferente dos outros elementos HTML, o id é gerado concatenando o nome
     * mais uniqid(), para a utilização de label em grupos de radiobuttons
     * @param type $name 
     */
    public function __construct($name) {
        parent::__construct();
        $this->element->name = $name;
        $this->element->id = $name . uniqid();
        $this->element->type = 'radio';
    }

    /**
     * Configura o estado bistate do componente CheckBox de
     * Formulário HTML;
     *
     * @param boolean $bool
     */
    public function isChecked($bool = false) {
        if (is_bool($bool) && $bool == TRUE) {
            $this->element->checked = "checked";
        } else {
            $this->triggerError(__CLASS__, __METHOD__);
        }
    }

}
