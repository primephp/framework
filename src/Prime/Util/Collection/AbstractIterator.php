<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Util\Collection;

use ArrayIterator;
use Prime\Util\Exception\NoSuchElementException;
use Prime\Util\Interfaces\ICollection;

/**
 * Implementa uma interface padrão para interação de elementos de uma coleção
 * também implementando as interfaces ITERATOR padrão do PHP, permitindo uma
 * iteração apenas para frente, não permitindo voltar, apenas reiniciar
 *
 * @author 85101346
 */
abstract class AbstractIterator extends ArrayIterator {

    /**
     * Instacia um objeto do Tipo ListIterator para iteração com um objeto do tipo
     * AbstractList, e se configura internamente com os elementos contidos na List
     * passada como parâmetro
     * 
     * @param AbstractList $list        	
     */
    public function __construct(ICollection $list) {
        parent::__construct($list->toArray());
    }

    /**
     * Insere o elemento especificado na lista
     * 
     * @param mixed $e        	
     */
    public function add($e) {
        return $this->append($e);
    }

    /**
     * Retorna true se o iterador de lista tem mais elementos ao atravessar a
     * lista na frente.
     * 
     * @return boolean
     */
    public function hasNext() {
        if ($this->nextIndex() >= $this->count()) {
            return FALSE;
        }
        if ($this->offsetExists($this->nextIndex())) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Retorna o próximo elemento da lista e avança a posição do cursor.
     */
    public function getNext() {
        if ($this->hasNext()) {
            $this->next();
            return $this->current();
        } else {
            throw new NoSuchElementException('Não há mais elemento, o Iterador ja ' . 'chegou no fim da Lista');
        }
    }

    /**
     * Move para o próximo elemento
     */
    public function next() {
        parent::next();
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
     * Remove da lista o último elemento retornado por next() ou previous()
     */
    public function remove() {
        $this->offsetUnset($this->key());
    }

    /**
     * Substitui o último elemento retornado por next() ou previous() pelo
     * elemento especificado
     * 
     * @param mixed $e        	
     */
    public function set($e) {
        $this->offsetSet($this->key(), $e);
    }

    /**
     * Retorna o elemento corrente de acordo com a última posição do ponteiro
     * 
     * @return mixed
     */
    public function current() {
        return parent::current();
    }

    /**
     * Retorna a posição atual do índice;
     * 
     * @return int O índice atual do Iterador
     */
    public function key() {
        return parent::key();
    }

    /**
     * Rebobina o iterador para a posição inicial
     * 
     */
    public function rewind() {
        return parent::rewind();
    }

    /**
     * Verifica se a posição atual do iterador é uma posição válida
     * @return boolean Retorna TRUE se a posição atual é valida e FALSE caso não
     */
    public function valid() {
        return parent::valid();
    }

}
