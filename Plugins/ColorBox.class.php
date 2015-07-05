<?php

namespace Prime\Plugins;

use Prime\Html\Base\HTMLScript;

/**
 * Descrição da Classe ColorBox
 * @package Prime\Plugins
 * @author TomSailor
 * @since 08/06/2011
 */
class ColorBox {

    private $elements = array();
    private $properties;

    public function __construct() {
        
    }

    private function getElements() {
        $elements = "\n$(document).ready(function(){";
        foreach ($this->elements as $value) {
            $elements .= "\n" . $value->getOutput();
        }
        return $elements . "\n" . "});\n";
    }

    public function add(ColorBoxElement $element) {
        $this->elements[] = $element;
    }

    public function getOutput() {
        $box = new HTMLScript();
        $box->appendChild($this->getElements());

        return $box->getOutput();
    }

    public function printOut() {
        echo $this->getOutput();
    }

}

