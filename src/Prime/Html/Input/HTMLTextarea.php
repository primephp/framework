<?php

namespace Prime\Html\Input;

/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL - 2008
 *
 *
 * Concluida
 */
class HTMLTextarea extends HTMLInput {

    /**
     * @param string $name
     */
    public function __construct($name) {
        parent::__construct("textarea");
        $this->element->name = $name;
        $this->element->id = $name;
        $this->element->type = 'text';
        $this->element->rows = "3";
        $this->element->cols = "30";
        $this->element->appendChild('');
    }

    /**
     * @return void
     * @param string rows
     */
    public function setRows($rows) {
        if (is_numeric($rows)) {
            $this->element->rows = (int)$rows;
        } else {
            $this->triggerError(__CLASS__, __METHOD__);
        }
    }

    /**
     * @param string $cols
     */
    public function setCols($cols) {
        if (is_numeric($cols)) {
            $this->element->cols = (int)$cols;
        } else {
            $this->triggerError(__CLASS__, __METHOD__);
        }
    }

    /**
     * Adiciona um texto sequencialmente ao HTMLInputTextarea
     * e pode ser reescrita para inserir texto em qualquer posicao
     * dentro do compenente. Este componente está sendo elaborado para
     * uso com Ajax, logo se aperfeiçoamento trará grandes benefícios.
     * @param string $text
     */
    public function addText($text) {
        if (is_string($text)) {
            $this->element->appendChild($text);
        } else {
            $this->triggerError(__CLASS__, __METHOD__);
        }
    }

}
