<?php

namespace Prime\DataTypes;
/**
 * @package Prime\DataTypes
 */
class TInteger extends Object implements INumber {

    private $value;

    public function Integer($value) {
        if (!is_numeric($value)) {
            throw new Exception("Passado caracter:" . $value . ".  Tipo ilegal, deveria ser numérico... ");
        }
        $this->value = (int) $value;
    }

    /**
     *
     */
    public function equals(Object $obj) {
        if (!$obj instanceof TInteger) {
            return false;
        }
        if (intval($this->value) === $obj->valueOf()) {
            return true;
        }
        return false;
    }

    /**
     *
     */
    public function valueOf() {
        return intval($this->value);
    }

    /**
     * Converte o número para String
     */
    public function __toString() {
        return (string) $this->value;
    }

}


