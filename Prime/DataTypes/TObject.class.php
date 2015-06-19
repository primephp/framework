<?php

namespace Prime\DataTypes;

if (PHP_VERSION < 5.3) {
    throw new Exception('Versão do PHP inferior a 5.3');
}

/**
 * Descrição de TObject
 * @name TObject
 * @package Prime\DataTypes
 * @version 1.0
 * @since 22/10/2011
 * @access public
 * @create 11/08/2012
 * @author tom
 */
class TObject {

    protected function getClone() {
        return (clone $this);
    }

    public function equals(TObject $obj) {
        if ($obj === $this) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    protected function toString() {
        return get_class($this);
    }

    public function hashCode() {
        return hash('sha512', $this->toString());
    }

}

