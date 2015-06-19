<?php

namespace Prime\DataTypes;

/**
 * Descrição da Classe Numeric
 * Manipula números
 * @name Numeric
 * @package Prime\DataTypes
 * @version 1.0
 * @author TomSailor
 * @since 18/08/2011
 * @access public
 */
class TNumeric {

    public function __construct($value) {
        $this->value = $value;
    }

    /**
     * Método toFloat
     * Converte o valor para Float
     * @return float $value 
     */
    public function toFloat() {
        $this->value = (float) $this->value;
        return $this->value;
    }

    /**
     * Método sum
     * <br>
     * Soma o Valor passado com o valor do objeto
     * @param TNumeric $value Valor a ser somado
     * @return TNumeric 
     */
    public function sum($value) {
        $this->value += $value;
        return new TNumeric($this->value);
    }

    /**
     * Método sum
     * Subtrai o valor passado do valor do objeto
     * @param TNumeric $value Valor a ser subtraído
     * @return TNumeric 
     */
    public function reduce($value) {
        $this->value -= $value;
        return new TNumeric($this->value);
    }

}

