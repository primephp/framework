<?php

namespace Prime\Core;

use Prime\Core\TNumber;

/**
 * Definição da Classe Integer
 * A classe Integer converte o tipo primitivo int do PHP em uma classe Integer
 * @dateCreate 30/05/2014
 * @author Elton Luiz
 */
class TInteger extends TNumber {

    /**
     * Instancia um objeto do tipo Inteiro
     * @param int|string|TString|NULL $int
     */
    public function __construct($int = NULL) {
        $this->setMinValue(-(PHP_INT_MAX));
        $this->setMaxValue(PHP_INT_MAX);
        if (!is_null($int)) {
            $this->setValue($int);
        }
        $this->data['min-value'] = -(PHP_INT_MAX);
        $this->data['max-value'] = PHP_INT_MAX;
    }

    /**
     * Verifica se o valor a ser atribuído ao objeto está entre o min e o max
     * permitido pelo PHP ou pelo definido
     * @param int $value
     */
    private function verifyValue($value) {
        if ($value <= $this->getMinValue()) {
            return FALSE;
        }
        if ($value >= $this->getMaxValue()) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Define o valor máximo a ser aceito pelo objeto Integer, podendo ser definido
     * como valor maximo o valor inferior ou igual ao máximo aceito pelo PHP
     * (9223372036854775807) ou caso o objeto Integer já tenha valor atribuído 
     * o valor atribuído como máximo não pode ser superior ao do objeto
     * @param int $max O valor máximo que pode ser aceito pelo objeto Integer
     * @return Boolean Retorna TRUE caso o valor pode ser atribuído como máximo
     * e falso caso contário
     */
    public function setMaxValue($max) {
        if ($max <= PHP_INT_MAX) {
            $this->data['max-value'] = $max;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Retorna 
     * @return int
     */
    public function getMaxValue() {
        return $this->data['max-value'];
    }

    /**
     * Define o valor mínimo a ser aceito pelo objeto Integer, podendo ser definido
     * como valor mínimo o valor superior ou igual ao mínimo aceito pelo PHP  
     * (-9223372036854775807) ou caso o objeto Integer já tenha valor atribuído 
     * o valor atribuído como mínimo não pode ser inferior ao do objeto
     * @param int $min O valor mínimo que pode ser aceito pelo objeto Integer
     * @return Boolean Retorna TRUE caso o valor pode ser atribuído como mínimo
     * e falso caso contário
     */
    public function setMinValue($min) {
        $phpMin = -(PHP_INT_MAX);
        if ($min >= $phpMin) {
            $this->data['min-value'] = $min;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Retorna o valor mínimo aceito pelo objeto Integer
     * @return int
     */
    public function getMinValue() {
        return $this->data['min-value'];
    }

    /**
     * Retorna o valor interno do Objeto Integer caso o mesmo seja chamado como
     * uma string
     * @return string
     */
    public function __toString() {
        return $this->toString();
    }

    /**
     * Retorna o valor deste Integer como uma String
     * @return string
     */
    public function toString() {
        return (string) $this->getValue();
    }

    /**
     * Retorna o valor interno do objeto Integer
     * @return int
     */
    public function getValue() {
        return (string) $this->data['value'];
    }

    /**
     * Atribui um valor ou um novo valor ao objeto Inteiro
     * @param type $int
     * @return Boolean Retorna TRUE se o valor pode ser atribuido com sucesso, 
     * do contrário retorna FALSE;
     */
    public function setValue($int) {
        if (is_int($int)) {
            $value = $int;
        } else
        if (is_string($int)) {
            $value = (int) $int;
        } else
        if ($int instanceof TString) {
            $value = (int) $int->getValue();
        } else if ($int instanceof TInteger) {
            $value = $int->getValue();
        } else {
            $value = NULL;
        }

        $this->data['value'] = $value;
    }

    /**
     * Retorna o valor deste Integer como um int.
     * @return int
     */
    public function intValue() {
        return (int) $this->getValue();
    }

    /**
     * Retorna o valor deste integer como Float
     * @return TFloat
     */
    public function toFloat() {
        return new TFloat($this->getValue());
    }
    
    /**
     * Retorna o boleano do valor do objeto
     * @return boolean
     */
    public function toBool(){
        return (bool) $this->getValue();
    }

    /**
     * A partir de uma string tenta analisá-la e retorna um int
     * Caso seja um misto de letras e número, retorna apenas os números contídos
     * na string
     * @param string $str
     * @return int
     */
    public static function parseInt($str) {
        return (int) $str;
    }

    /**
     * Retorna um objeto Integer configurado com o valor passado com parâmetro
     * caso o valor seja um inteiro, do contrário sanitiza a string passada para
     * inteiro
     * @param type $str
     * @return TInteger
     */
    public static function parseInteger($str) {
        return new TInteger((int) $str);
    }

    /**
     * Verifica se os valores inteiros são iguais
     * @param int $x
     * @param int $y
     * @return boolean
     */
    public static function compare($x, $y) {
        if (is_int($x) && is_int($y)) {
            if ($x == $y) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Supondo que o especificado String representa um número inteiro, 
     * retorna um novo objeto Integer inicializado para que o Integer
     * @param str $str
     * @return TInteger
     */
    public static function valueOf($str) {
        return new TInteger($str);
    }

    /**
     * @inheritDoc
     */
    public function isEmpty() {
        if (empty($this->data['value'])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
