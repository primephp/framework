<?php

/*
 * Copyright (C) 2014 comforsup-0213 This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Prime\Util\Collection;

use ArrayObject;
use Prime\Util\Exception\NoSuchElementException;
use Prime\Util\Interfaces\IListIterator;

/**
 * Descrição de ListIterator
 * @dateCreate 16/06/2014
 * @author Elton Luiz
 */
class ListIterator implements IListIterator {

    /**
     * Armazena a lista a ser iterada
     * 
     * @var ArrayObject
     */
    protected $_list;
    protected $_index;
    private $_size;

    /**
     * Instacia um objeto do Tipo ListIterator para iteração com um objeto do tipo
     * AbstractList, e se configura internamente com os elementos contidos na List
     * passada como parâmetro
     * 
     * @param AbstractList $list        	
     */
    public function __construct(AbstractList $list) {
        $this->_list = $list->toArrayObject();
        $this->_size = count($this->_list);
        $this->rewind();
    }

    /**
     * Insere o elemento especificado na lista
     * 
     * @param mixed $e        	
     */
    public function add($e) {
        return $this->_list->append($e);
    }

    /**
     * Retorna true se o iterador de lista tem mais elementos ao atravessar a
     * lista na frente.
     * 
     * @return boolean
     */
    public function hasNext() {
        if ($this->nextIndex() >= $this->_size) {
            return FALSE;
        }
        if ($this->_list->offsetExists($this->nextIndex())) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Retorna true se o iterador de lista tem mais elementos ao atravessar a
     * lista no sentido inverso.
     * 
     * @return boolean
     */
    public function hasPrevious() {
        if ($this->previousIndex() < 0) {
            return FALSE;
        }
        if ($this->_list->offsetExists($this->nextIndex())) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Retorna o próximo elemento da lista e avança a posição do cursor.
     */
    public function next() {
        if ($this->hasNext()) {
            $this->_index += 1;
            return $this->_list->offsetGet($this->key());
        } else {
            throw new NoSuchElementException('Não há mais elemento, o Iterador ja ' . 'chegou no fim da Lista');
        }
    }

    /**
     * Retorna o índice do elemento que seria devolvido por uma chamada
     * subseqüente a next ().
     * 
     * @return int O próximo índice do elemento, caso a lista esteja no fim, retorna o
     *         tamanho da lista
     */
    public function nextIndex() {
        return $this->key() + 1;
    }

    /**
     * Retorna o elemento anterior da lista e move a posição do cursor
     * para trás.
     */
    public function previous() {
        if ($this->hasPrevious()) {
            $this->_index -= 1;
            return $this->_list->offsetGet($this->key());
        } else {
            throw new NoSuchElementException('Não há mais elementos, o Iterador ja ' . 'chegou no início da Lista');
        }
    }

    /**
     * Retorna o índice do elemento que seria retornado por uma chamada subsequente
     * ao previous()
     * 
     * @return int O índice anterior a posição atual do ponteiro. Retorna -1 se a o Iterador
     *         está no início da lista
     */
    public function previousIndex() {
        return $this->key() - 1;
    }

    /**
     * Remove da lista o último elemento retornado por next() ou previous()
     */
    public function remove() {
        if ($this->valid()) {
            $this->_list->offsetUnset($this->key());
        }
    }

    /**
     * Substitui o último elemento retornado por next() ou previous() pelo
     * elemento especificado
     * 
     * @param mixed $e        	
     */
    public function set($e) {
        $e;
    }

    /**
     * Retorna o elemento corrente de acordo com a última posição do ponteiro
     * 
     * @return mixed
     */
    public function current() {
        return $this->_list->offsetGet($this->key());
    }

    /**
     * Retorna a posição atual do índice;
     * 
     * @return int O índice atual do Iterador
     */
    protected function key() {
        return $this->_index;
    }

    /**
     * Rebobina o iterador para a posição inicial
     * (posição -1)
     */
    public function rewind() {
        $this->_index = - 1;
    }

    public function valid() {
        ;
    }

}
