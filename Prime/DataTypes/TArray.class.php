<?php

use Prime\DataTypes\Interfaces\IType,
    Prime\DataTypes\StdType;

/**
 * Descrição da Classe ArrayType
 * @name ArrayType
 * @package Prime\DataTypes
 * @version 1.0
 * @author tom
 * @since 22/10/2011
 * @access public
 */
class TArray extends StdType implements IType {

    /**
     * Armazena os valores do Objeto ArrayType
     * @var array  
     */
    private $colletion = array();

    /**
     * Armazena os index Associativos do valores do Objeto ArrayType
     * @var type 
     */
    private $associate = array();
    private $index = NULL;
    private $size = NULL;

    public function __construct($colletion = NULL) {
        $this->index = -1;
        $this->size = 0;

        if (!is_null($colletion)) {
            foreach ($colletion as $key => $value) {
                $index = $this->size();
                $this->associate[$index] = isset($key) ? "$key" : "$index";
                $this->colletion[$index] = isset($value) ? "$value" : "$index";

                $this->size++;
            }
        }
    }

    public function cloneArray() {
        $colletion = $this->toArray();

        return new TArray($colletion);
    }

    public function getValue($key) {
        return $this->valueOf($key);
    }

    public function setValue($value) {
        $index = $this->size();
        $this->associate[$index] = "$index";
        $this->colletion[$index] = "$value";

        $this->size++;
    }

    public function toArray() {
        $array = array();
        foreach ($this->colletion as $key => $value) {
            $array[$this->associate[$key]] = $value;
        }

        return $array;
    }

    public function add($value, $key = NULL) {
        $index = $this->size();
        $this->associate[$index] = is_null($key) ? "$index" : "$key";
        $this->colletion[$index] = "$value";

        $this->size++;
    }

    public function clear() {
        $this->associate = array();
        $this->colletion = array();
        $this->size = 0;
    }

    public function toClone() {
        return $this;
    }

    public function valueExists($value) {
        $key = array_search($value, $this->colletion);

        if ($key) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function keyExists($key) {
        $key = array_search($value, $this->associate);

        if ($key) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function indexOf($value) {
        $key = array_search($value, $this->colletion);

        return $this->associate[$key];
    }

    public function valueOf($key) {
        $key = array_search($value, $this->associate);

        return $this->colletion[$key];
    }

    public function toFirst() {
        if (isset($this->associate[0])) {
            $this->index = 0;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function toNext() {
        if (isset($this->associate[$this->index + 1])) {
            $this->index++;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function toPrevious() {
        if ($this->index > 0) {
            if (isset($this->associate[$this->index - 1])) {
                $this->index--;
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $this->toFirst();
        }
    }

    public function toLast() {
        $this->index = $this->size() - 1;
    }

    public function nextIndex() {
        if (isset($this->associate[$this->index + 1])) {
            return $this->index + 1;
        } else {
            return FALSE;
        }
    }

    public function previousIndex() {
        if (isset($this->associate[$this->index - 1])) {
            return $this->index - 1;
        } else {
            return FALSE;
        }
    }

    public function lastIndex() {
        if (isset($this->associate[$this->size() - 1])) {
            return $this->associate[$this->size() - 1];
        } else {
            return FALSE;
        }
    }

    public function firstIndex() {
        if (isset($this->associate[0])) {
            return $this->associate[0];
        } else {
            return FALSE;
        }
    }

    public function remove($key) {
        $i = array_search("$key", $this->associate);

        if ($i) {
            unset($this->colletion[$i]);
            unset($this->associate[$i]);

            $this->size--;

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function removeRange($from, $to) {
        
    }

    public function set($key, $value) {
        $this->add($value, $key);
    }

    public function size() {
        return $this->size;
    }

    public function sort() {
        
    }

    public function aSort() {
        
    }

    public function serialize() {
        return serialize($this->toArray());
    }

    private function unserialize() {
        
    }

}

?>