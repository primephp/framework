<?php

namespace Prime\Html\Input;

use Prime\Html\Base\HTMLElement,
    Exception;

/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL - 2008
 *
 *
 * Concluida
 *
 */
abstract class HTMLInput {

    protected $events = array();
    protected $styles = array();
    protected $label = NULL;

    /**
     * Armazena um HTMLElement
     * @var HTMLElement
     */
    protected $element;
    protected static $eventList = array();

    public function __construct($tagname = "input") {
        $this->element = new HTMLElement($tagname);
    }

    /**
     *
     * @param boolean $event
     * @return string
     */
    private function checkEvent($event) {
        $event = strtolower($event);
        self::$eventList["click"] = "onclick";
        self::$eventList["mouseover"] = "onmouseover";
        self::$eventList["mousemove"] = "onmousemove";
        self::$eventList["mouseout"] = "onmouseout";
        self::$eventList["mousedown"] = "onmousedown";
        self::$eventList["mouseup"] = "onmouseup";
        self::$eventList["keyup"] = "onkeyup";
        self::$eventList["keydown"] = "onkeydown";
        self::$eventList["keypress"] = "onkeypress";
        self::$eventList["blur"] = "onblur";
        self::$eventList["change"] = "onchange";
        self::$eventList["dblclick"] = "ondblclick";
        self::$eventList["focus"] = "onfocus";
        self::$eventList["help"] = "onhelp";
        self::$eventList["select"] = "onselect";

        if (array_key_exists($event, self::$eventList) ||
                array_search($event, self::$eventList, true)) {
            return true;
        }
        return false;
    }

    /**
     * Configura o rótulo do componente...
     *
     * @param string $label
     * @param bool $bool
     */
    public function setLabel($label) {
        if (is_string($label)) {
            $HTMLLabel = new HTMLElement('label');
            $HTMLLabel->appendChild($label);
            $HTMLLabel->setAttribute('for', $this->element->id);

            $this->label = $HTMLLabel;
        } else {
            $this->triggerError(__CLASS__, __METHOD__);
        }
    }

    /**
     * Configura o valor do atributo Value de um elemento
     * de formulário HTML
     *
     * @return void
     * @param string $value
     */
    public function setValue($value) {
        $this->element->value = $value;
    }

    /**
     * Recebe um string contendo o nome do elemento
     *
     * @param string $nome
     */
    public function setName($name) {
        if (is_string($name)) {
            $this->element->name = $name;
            $this->element->id = $name;
        }
    }

    public function setStyle($property, $value) {
        $this->element->setStyle($property, $value);
    }

    public function setAttribute($name, $value) {
        $this->element->setAttribute($name, $value);
    }

    /**
     * Configura o atributo maxlength de um elemento de
     * Formulário HTML
     *
     * @param string $maxlength
     */
    public function setMaxLength($maxlength) {
        if (is_numeric($maxlength)) {
            $this->element->maxlength = (int) $maxlength;
        } else {
            $this->triggerError(__CLASS__, __METHOD__);
        }
    }

    /**
     * Configura o parâmetro HTML size de um componente
     * de Formulário HTML.
     *
     * @param integer $size
     */
    public function setSize($size) {
        if (is_int($size)) {
            $this->element->size = $size;
        } else {
            throw new Exception("Passagem de parâmetro inválido. Método: " . __METHOD__ . " da Classe:" . __CLASS__);
        }
    }

    /**
     * Configuração dos atributos de strings de eventos.
     * @param string $event
     * @param string $function
     */
    public function addEvent($event, $function) {
        if ($this->checkEvent($event)) {
            $this->element->$event = $function;
        } else {
            $this->triggerError(__CLASS__, __METHOD__);
        }
    }

    /**
     * Configura a classe CSS ao qual este compenente pertence
     *
     * @param string $className
     *
     * @return
     */
    public function addCSSClass($className) {
        if (is_string($className)) {
            $this->element->class = $className;
        } else {
            $this->triggerError(__CLASS__, __METHOD__);
        }
    }

    /**
     * Configura o atributo CSS style do compenente
     *
     * @return void
     * @param string $cssStyle
     */
    public function addCSSStyle($cssStyle = null) {
        if (is_string($cssStyle)) {
            $this->element->style = $cssStyle;
        } else {
            $this->triggerError(__CLASS__, __METHOD__);
        }
    }

    /**
     * Configura o Parâmetro ID
     *
     * @param string $id
     */
    public function setId($id) {
        if (is_string($id)) {
            $this->element->id = $id;
        } else {
            $this->triggerError(__CLASS__, __METHOD__);
        }
    }

    /**
     * Auxilia na criação de um elemento de Formulário
     * HTML desabilitado por padrão.
     *
     * @param boolean $boolean
     */
    public function isReadOnly($boolean = TRUE) {
        if (is_bool($boolean)) {
            $this->readonly = ($boolean == TRUE) ? " readonly " : " ";
        } else {
            $this->triggerError(__CLASS__, __METHOD__);
        }
    }

    /**
     * Auxilia na criação de um elemento de Formulário
     * HTML desabilitado por padrão.
     *
     * @param boolean $boolean
     */
    public function isEnabled($boolean = FALSE) {
        if (is_bool($boolean)) {
            $this->element->disabled = ($boolean == true) ? " disabled " : " ";
        } else {
            $this->triggerError(__CLASS__, __METHOD__);
        }
    }

    /**
     * Configura o valor do atributo title do elemento
     * de Formulário HTML
     *
     * @param string $title
     */
    public function setTitle($title) {
        $this->element->title = $title;
    }

    /**
     * Configura o valor do atributo tabIndex do elemento
     * de Formulário HTML
     *
     * @param string $index
     */
    public function setTabIndex($index) {
        if (is_numeric($index)) {
            $this->element->tabindex = (int) $index;
        } else {
            $this->triggerError(__CLASS__, __METHOD__);
        }
    }

    /**
     * Imprime a saída do elemento, já formato e
     * preparado para a visualização na página HTML
     *
     * Este método, seja ele herdado ou redefinido nas subclasses
     * tem a função adicional principal a de compor um decorator onde as
     * interfaces de outros objetos, como a de HTMLForm deve implementar
     * @return string
     *
     */
    public function printOut() {
        $this->element->printOut();
    }

    public function getOutput() {
        $return = $this->element->getOutput();
        if (!is_null($this->label)) {
            if ($this instanceof HTMLInputCheckbox || $this instanceof HTMLInputRadio) {
                $return .= $this->label->getOutput();
            } else {
                $return = $this->label->getOutput() . $this->element->getOutput();
            }
        }
        return $return;
    }

    protected function triggerError($class, $method) {
        trigger_error("Passagem de parâmetro inválido em $class::$method", E_USER_ERROR);
    }

}

