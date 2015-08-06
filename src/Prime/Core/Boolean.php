<?php

namespace Prime\Core;

/**
 * Descrição da Classe Boolean
 * @package Prime\core
 * @author comforsup-0212
 * @dateCreate $(date)
 */
class Boolean extends Object
{

    const B_TRUE = TRUE;
    const B_FALSE = FALSE;

    public function __construct($bool)
    {
        $this->data = NULL;
        $this->setValue($bool);
    }

    /**
     * Retorna o valor booleano do objeto Boolean caso o mesmo seja chamado
     * como uma string
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }

    /**
     * Retorna o valor booleano do objeto Boolean
     * @return boolean
     */
    public function getValue()
    {
        return $this->data;
    }

    public function setValue($value)
    {
        $false = ['false', 'False', 'FALSE', 'no', 'No', 'n', 'N', '0', 'off',
            'Off', 'OFF', false, 0, null];
        $true = ['true', 'True', 'TRUE', 'yes', 'Yes', 'y', 'Y', '1',
            'on', 'On', 'ON', true, 1];
        if (in_array($value, $false, TRUE)) {
            $bool = FALSE;
        } else
        if (in_array($value, $true, TRUE)) {
            $bool = TRUE;
        } else {
            $bool = NULL;
        }
        $this->data = $bool;
    }

    /**
     * Compara dois valores booleanos
     * @param Boolean $x
     * @param Boolean $y
     * @return boolean
     */
    public static function compare($x, $y)
    {
        if ($x === $y) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Compara esta instancia de Boolean com uma outra instância
     * @param Boolean $b
     * @return Boolean
     */
    public function compareTo(Boolean $b)
    {
        if ($this->getValue() === $b->getValue()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Analisa o argumento string como um boolean. O boolean 
     * retornado representa o valor verdadeiro se o argumento string 
     * não é nulo e é igual, ignorando caso, para a string "true". 
     * @param string $s
     */
    public static function parseBoolean($s)
    {
        return new Boolean($s);
    }

    /**
     * Retorna uma instância de Boolean representando o valor booleano 
     * especificado. Se o valor booleano especificada for verdadeira, 
     * este método retorna Boolean.TRUE; se for falsa, este método 
     * retorna Boolean.FALSE.
     * @param mixed $b
     * @return Boolean uma instância de Boolean $b
     */
    public static function valueOf($b)
    {
        return new Boolean($b);
    }

    /**
     * Retorna um objeto String representando o boolean especificado.
     * @return String
     */
    public function toString()
    {
        return self::getString($this->getValue());
    }

    /**
     * Retorna um objeto String representando o boolean especificado.
     * @param Boolean $b
     * @return String
     */
    public static function getString($b)
    {
        if ($b == TRUE) {
            return new String('TRUE');
        } else
        if ($b == FALSE) {
            return new String('FALSE');
        } else {
            throw new \InvalidArgumentException('Não suportado valores diferentes de booleans');
        }
    }

}
