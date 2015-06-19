<?php

namespace Prime\DataTypes;

/**
 * @name TFloat
 * @package Prime\DataTypes
 */
class TFloat extends Object implements INumber {

    /**
     *
     * @param numeric $value
     */
    public function Float($value) {
        if (!is_numeric($value)) {
            throw new Exception("Tipo ilegal, deveria ser num�rico... ");
        }
        $this->value = (float) $value;
    }

    public function equals(Object $obj) {
        if (!$obj instanceof TFloat) {
            return false;
        }
        if (floatval($this->value) === $obj->valueOf()) {
            return true;
        }
        return false;
    }

    /**
     *
     */
    public function valueOf() {
        return floatval($this->value);
    }

    /**
     *
     */
    public function __toString() {
        return (string) $this->value;
    }

}


