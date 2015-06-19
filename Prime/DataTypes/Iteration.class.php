<?php

namespace Prime\DataTypes;

/**
 * @name Iteration
 * @package Prime\DataTypes
 */
class Iteration implements IIterable {

    private $collection = null;
    private $_index = 0;
    private $size = 0;

    public function __construct(Object $obj) {
        if ($obj instanceof IListable) {
            $this->size = $obj->getSize();
            $this->collection = $obj->getElements();
        } else {
            trigger_error("Tipo Inválido. Dados passado para " . __METHOD__ . " em " . __CLASS__ . " não implementa a interface IListable.");
        }
    }

    /**
     * @return boolean
     * Retorna true se ainda existir algum registro
     */
    public function getNext() {
        //metodo de array
        return current($this->collection);
    }

    public function hasNext() {
        return next($this->collection);
    }

    public function resetIterator() {
        reset($this->collection);
    }

    public function getSize() {
        return $this->size;
    }

    public function getLast() {
        return end($this->collection);
    }

    public function current() {
        return current($this->collection);
    }

    /**
     * Retorna a chave atual 
     * @return int A chave atual do elemento
     */
    public function key() {
        key($this->collection);
    }

    /**
     * Move para o próximo elemento do array
     * e retorna o valor armazenado na posição
     */
    public function next() {
        return next($this->collection);
    }

    /**
     * Retorna o Iterador para o primeiro elemento
     */
    public function rewind() {
        
    }

    /**
     * Verifica se a posição atual é válida
     * @return boolean
     */
    public function valid() {
        if (isset($this->collection[$this->_index])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
