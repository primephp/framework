<?php

namespace Prime\DataTypes;

use Prime\View\IView;

/**
 * Descrição da Classe Abstrata StdType
 * @name TType
 * @package Prime\DataTypes
 * @version 1.0
 * @author tom
 * @since 22/10/2011
 * @access public
 */
abstract class TType implements IView {

    protected $value;

    public function __construct($string = null) {
        $this->value = $string;
    }

    public function __toString() {
        return $this->getValue();
    }

    /**
     * Método getValue
     * @return str Valor
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Método getOutput
     * Pega o valor da String a ser impresso na tela
     * @return str Valor 
     */
    public function getOutput() {
        return $this->getValue();
    }

    /**
     * Método printOut
     * Imprime na tela o valor da String
     */
    public function printOut() {
        echo $this->getOutput();
    }

    /**
     * Retorna o Valor da String
     * (seu conteúdo)
     * @return str Conteúdo da String 
     */
    public function valueOf() {
        return $this->value;
    }

    /**
     * Método setValue
     * @param str $value Valor a ser definido para a String
     */
    public function setValue($value) {
        $this->value = $value;
    }

    public function __destruct() {
        unset($this->value);
    }

}


