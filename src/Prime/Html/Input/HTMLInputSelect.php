<?php

namespace Prime\Html\Input;

use Prime\Html\Base\HTMLElement;
use Prime\Util\Collection\ArrayList;
use Prime\Util\Interfaces\ICollection;
use Prime\Util\Interfaces\IList;


class HTMLInputSelect extends HTMLInput {

    private $options = array();
    private $selection = array();

    /**
     *
     * @param string $name
     */
    public function __construct($name) {
        parent::__construct("select");
        $this->element->name = $name;
        $this->element->id = $name;
    }

    /**
     * Adiciona um elemento option no Select
     * @return void
     * @param string $value
     * @param string $label
     */
    public function addOption($val, $text) {
        if (is_string($val) && is_string($text)) {
            $option = new HTMLElement("option");
            $option->value = $val;
            $option->appendChild($text);
            $this->options[] = $option;
        } else {
            $this->triggerError(__CLASS__, __METHOD__);
        }
    }

    /**
     * Deve receber uma coleção de objetos ArrayList cujo conteúdo deve ser os valores de
     * de string html option value e text. Este metodo opera junto de  addOption().
     * @param ICollection $collection
     */
    public function addOptions(IList $collection, $concat = false) {
        if ($collection instanceof IList) {
            while ($collection->hasNext()) {
                $option = new HTMLElement("option");
                $options = $collection->getNext();
                $option->value = $options->contentAt(0);
                if ($concat == true) {
                    $option->appendChild($options->contentAt(0) . " - " . $options->contentAt(1));
                } else {
                    if ($options->getSize() == 2) {
                        $option->appendChild($options->contentAt(1));
                    } else {
                        $option->appendChild($options->contentAt(0));
                    }
                }
                $this->options[] = $option;
            }
        } else {
            $this->triggerError(__CLASS__, __METHOD__);
        }
    }

    /**
     * Configura o valor de multiplo para o select
     * @param boolean $multi
     * @param integer $size
     */
    public function isMultiple($multi = false, $size = 10) {
        if ($multi === TRUE) {
            $name = $this->element->getAttribute("name");
            $this->element->setAttribute("name", "{$name}[]");
            $this->element->setAttribute("id", "{$name}[]");
            $this->element->multiple = "multiple";
        }
        $this->element->size = $size;
    }

    public function setSize($size) {
        $this->element->size = $size;
    }

    /**
     * Determina qual ser� o index selecionado por padrao
     * @return void
     * @param mixed $selection;
     */
    public function setSelected($selection) {
        if (is_int($selection) || is_string($selection)) {
            $this->selection[] = $selection;
        } else if (is_array($selection)) {
            $this->selection = $selection;
        }
        if ($selection instanceof ArrayList) {
            $this->selection = $selection->toArray();
        }
    }

    /**
     * @todo Verificar o uso dos métodos de ArrayList não disponíveis
     */
    private function getSelected() {
        foreach ($this->selection as $value) {
            if ($value instanceof ArrayList) {
                while ($value->hasNext()) {
                    $selec = $value->getNext();
                    foreach ($this->options as $option) {
                        /* @var $option HTMLElement */
                        if ($option->getAttribute("value") == $value->contentAt(0)) {
                            echo "<br>N";
                            $option->selected = "selected";
                        }
                    }
                }
            } else {
                foreach ($this->options as $option) {
                    /* @var $option HTMLElement */
                    if ($option->getAttribute("value") == $value) {
                        $option->selected = "selected";
                    }
                }
            }
        }
    }

    public function printOut() {
        $this->getSelected();
        foreach ($this->options as $option) {
            $this->element->appendChild($option);
        }
        parent::printOut();
    }

    public
            function getOutput() {
        $this->getSelected();
        foreach ($this->options as $option) {
            $this->element->appendChild($option);
        }
        return parent::getOutput();
    }

}


