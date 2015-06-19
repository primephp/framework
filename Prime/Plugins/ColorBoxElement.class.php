<?php

namespace Prime\Plugins;

/**
 * Descrição da Classe ColorBoxElement
 * @package Prime\Plugins
 * @author TomSailor
 * @since 08/06/2011
 */
class ColorBoxElement {

    private $element;
    private $properties = array();

    public function __construct($element) {
        $this->element = $element;
        return $this;
    }

    public function __set($name, $value) {
        $this->properties[$name] = $value;
    }

    private function getProperties() {
        $prop = array();
        foreach ($this->properties as $key => $value) {
            if (is_numeric($value)) {
                $prop[] = $key . ":" . $value;
            } else
            if (is_bool($value)) {
                $prop[] = $key . ":" . $value;
            } else
            if (is_string($value)) {
                $prop[] = $key . ":'" . $value . "'";
            }
        }
        $prop = implode(",", $prop);
        return $prop;
    }

    public function getOutput() {
        $this->next = "avançar";
        $this->previous = "voltar";
        $this->opacity = '0.70';
        $out = "$(\"$this->element\").colorbox({{$this->getProperties()}}";
        $out.=");";
        return $out;
    }

}

