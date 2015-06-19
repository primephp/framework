<?php

namespace Prime\DataTypes;

use Prime\DataTypes\Interfaces\IType;

/**
 * Descrição da Classe BooleanType
 * Trata dos dados do tipo boleano
 * @name BooleanType
 * @package Prime\DataTypes
 * @version 1.0
 * @author tom
 * @since 22/10/2011
 * @access public
 */
class TBoolean extends StdType implements IType {

    private $false = array('false', 'False', 'FALSE', 'no', 'No', 'n', 'N', '0', 'off',
        'Off', 'OFF', false, 0, null);
    private $true = array('true', 'True', 'TRUE', 'yes', 'Yes', 'y', 'Y', '1',
        'on', 'On', 'ON', true, 1);

    public function __construct($value = NULL) {
        if ($this->is_boolean($value)) {
            $this->value = $value;
        } else {
            $this->value = FALSE;
            return FALSE;
        }
    }

    private function is_boolean($value) {
        $values = array_merge($this->true, $this->false);

        if (in_array($value, $values)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function verify($value) {
        if (in_array($value, $this->false, true)) {
            $out = FALSE;
        }

        if (in_array($in, $this->true, true)) {
            $out = TRUE;
        }

        return $out;
    }

    public function setValue($value) {
        if ($this->is_boolean($value)) {
            $this->value = $value;
            return TRUE;
        } else {
            $this->value = FALSE;
            return FALSE;
        }
    }

    public function getValue() {
        return $this->value;
    }

}


