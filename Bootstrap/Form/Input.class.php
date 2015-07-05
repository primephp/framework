<?php

namespace Prime\Bootstrap\Form;

use Prime\Html\Base\HTMLDiv,
    Prime\Html\Base\HTMLSpan,
    Prime\Html\Input\HTMLInput;

/**
 * Descrição de Input
 * HTMLInput configurado para uso com BootStrap
 * @package Prime\Bootstrap\Form
 * @create 24/03/2014
 * @author tom
 */
abstract class Input extends HTMLInput {

    protected $helpText;

    public function __construct($tagname = "input") {
        parent::__construct($tagname);
        $this->addCSSClass('form-control');
    }

    public function addHelpText($text) {
        $this->helpText = $text;
    }

    public function getHelpText() {
        return $this->helpText;
    }

    /**
     * 
     * @return string
     */
    protected function getHelpBlobck() {
        $return = NULL;

        if ($this->getHelpText()) {
            $span = new HTMLSpan($this->getHelpText());
            $span->addClass('help-block');
            $return = $span->getOutput();
        }

        return $return;
    }

    /**
     * Retorna o elemento HTML sem introduzi-lo dentro de uma tag DIV (form-group)
     * @return string
     */
    public function getInput() {
        return parent::getOutput();
    }

}
