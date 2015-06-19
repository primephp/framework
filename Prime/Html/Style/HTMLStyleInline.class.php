<?php

namespace Prime\Html\Style;

use Prime\View\View;

/**
 * Descrição de HTMLStyleInline
 * @name HTMLList
 * @package HTML
 * @subpackage HTMLElements
 * @version 1.0
 * @since 29/04/2012
 * @access public
 * @author Tom Sailor
 */
class HTMLStyleInline extends View {

    private $properties;

    public function __construct() {
        $this->properties = array();
    }

    public function setProperty($name, $value) {
        $this->properties[$name] = (string) $value;
    }

    /**
     * Retorna o valor da propriedade CSS
     * @param str $name Nome da propriedade
     * @return boolean 
     */
    public function getProperty($name) {
        if (isset($this->properties[$name])) {
            return $this->properties[$name];
        } else {
            return FALSE;
        }
    }

    public function setWidth($value, $pixel = TRUE) {
        ($pixel === TRUE) ? $value = "{$value}px" : $value;
        $this->setProperty('width', $value);
    }

    public function setHeight($value, $pixel = TRUE) {
        ($pixel === TRUE) ? $value = "{$value}px" : $value;
        $this->setProperty('height', $value);
    }

    public function setMinHeight($value) {
        $this->setProperty('min-height', $value);
    }

    public function setMinWidth($value) {
        $this->setProperty('min-width', $value);
    }

    public function setMaxHeight($value) {
        $this->setProperty('max-height', $value);
    }

    public function setMaxWidth($value) {
        $this->setProperty('max-width', $value);
    }

    public function setBorder($width = '1px', $style = 'solid', $color = '#000000') {
        $this->setProperty('border', "$width $style $color");
    }

    public function setPadding($value) {
        $this->setProperty('padding', $value);
    }

    public function setPaddingLeft($value) {
        $this->setProperty('padding-left', $value);
    }

    public function setPaddingTop($value) {
        $this->setProperty('padding-top', $value);
    }

    public function setPaddingBottom($value) {
        $this->setProperty('padding-bottom', $value);
    }

    public function setMargin($value) {
        $this->setProperty('margin', $value);
    }

    public function setMarginTop($value) {
        $this->setProperty('margin-top', $value);
    }

    public function setMarginBottom($value) {
        $this->setProperty('margin-bottom', $value);
    }

    public function setMarginRight($value) {
        $this->setProperty('margin-right', $value);
    }

    public function setMarginLeft($value) {
        $this->setProperty('margin-left', $value);
    }

    /**
     * Define a posição no qual o elemento deve boiar
     * @param mixed $value right/left/inherit/none 
     */
    public function setFloat($value) {
        $this->setProperty('float', $value);
    }

    public function setDisplay($value = 'none') {
        $this->setProperty('display', $value);
    }

    /**
     * Define o tipo de posicionamento do elemento
     * @param mixed $value relative/absolute/fixed/
     */
    public function setPosition($value = 'relative') {
        $this->setProperty('position', $value);
    }

    public function setBottom($value) {
        $value = (filter_var($value, FILTER_SANITIZE_NUMBER_INT));
        $this->setProperty('bottom', "{$value}px");
    }

    public function setTop($value) {
        $value = (filter_var($value, FILTER_SANITIZE_NUMBER_INT));
        $this->setProperty('top', "{$value}px");
    }

    public function setLeft($value) {
        $value = (filter_var($value, FILTER_SANITIZE_NUMBER_INT));
        $this->setProperty('left', "{$value}px");
    }

    public function setRight($value) {
        $value = (filter_var($value, FILTER_SANITIZE_NUMBER_INT));
        $this->setProperty('right', "{$value}px");
    }

    /**
     * Retorna todas as propriedades CSS com seu valores
     * @return string 
     */
    public function getOutput() {
        $css = '';
        foreach ($this->properties as $property => $value) {
            $css .= $property . ':' . $value . '; ';
        }

        if (!empty($css)) {
            return $css;
        }
    }

}


