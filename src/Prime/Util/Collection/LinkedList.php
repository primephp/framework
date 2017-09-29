<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Util\Collection;

use Prime\Core\Interfaces\IClonable;
use Prime\Core\TObject;
use Prime\Io\Interfaces\SerializableInterface;
use Prime\Util\Exception\NoSuchElementException;
use Prime\Util\Interfaces\IDeque;
use Prime\Util\Interfaces\IIterator;
use Prime\Util\Interfaces\IList;
use UnexpectedValueException;

/**
 * Descrição de LinkedList
 * Implementação da lista duplamente vinculada das interfaces Lista e LinkedList. 
 * Implementa todas as operações de lista opcional, e permite que todos os 
 * elementos (incluindo nulo).
 * Todas as operações de realizar como poderia ser esperado de uma lista 
 * duplamente ligado. Operações que índice para a lista irá percorrer a lista 
 * desde o início ou o fim, o que for mais perto do índice especificado. 
 * @author Elton Luiz
 * @createAt 23/08/2016
 */
class LinkedList extends AbstractSequentialList implements IList, IDeque, IClonable,
        SerializableInterface {

    /**
     * Inverte a ordem dos elementos contidos na lista
     * @return void
     */
    protected function reverse() {
        $this->collection = array_reverse($this->collection);
    }

    /**
     * Insere o elemento especificado no final da fila
     * @param mixed $e
     * @return boolean 
     */
    public function add($e) {
        parent::add($e);
    }

    /**
     * Insere o elemento especificado na frente da fila
     * @param mixed $e
     * @return void
     */
    public function addFirst($e) {
        if (!is_object($e)) {
            $e = TObject::create($e);
        }
        if (!$this->checkType($e)) {
            throw new UnexpectedValueException("Tipo de dados esperado {$this->getTypeCast()} em " . __METHOD__);
        }
        return array_unshift($this->collection, $e);
    }

    /**
     * Insere o elemento especificado no final da fila
     * @param mixed $e O elemento a ser adicionado na lista
     * @return void
     */
    public function addLast($e) {
        $this->add($e);
    }

    /**
     * Retorna <b>true</b> se a fila contém o elemento especificado
     * @param mixed $o
     * @return boolean
     */
    public function contains($o) {
        return parent::contains($o);
    }

    /**
     * Retorna um iterador sobre os elementos desta Deque em ordem sequencial
     * inversa
     * @return IIterator Iterador para os elementos da fila
     */
    public function descendingIterator() {
        $clone = $this->getClone();
        $clone->reverse();
        return new ListIterator($clone);
    }

    /**
     * Retorna, porém não remove, o primeiro elemento desta Deque
     * @return mixed
     */
    public function element() {
        return $this->getFirst();
    }

    /**
     * Retorna, porém não remove, o primeiro elemento da Deque
     * @return mixed
     */
    public function getFirst() {
        reset($this->collection);
        return current($this->collection);
    }

    /**
     * Retorna, porém não remove, o último elemento da Deque
     * @return mixed
     */
    public function getLast() {
        end($this->collection);
        return current($this->collection);
    }

    /**
     * Retorna um iterador sobre os elementos neste LinkedList na sequência correta.
     * @return IIterator
     */
    public function iterator() {
        return new ListIterator($this);
    }

    /**
     * Insere o elemento especificado na fila representado por este Deque 
     * (em outras palavras, no final da fila) 
     * @param mixed $e O elemento a ser adicionado
     * @return boolean Retorna TRUE caso seja adicionado com sucesso
     */
    public function offer($e) {
        $this->add($e);
    }

    /**
     * Insere o elemento especificado na parte da frente desta Deque
     * @param mixed $e O elemento a ser adicionado
     * @return boolean Retorna TRUE caso seja adicionado com sucesso
     */
    public function offerFirst($e) {
        $this->addFirst($e);
    }

    /**
     * Insere o elemento especificado no final desta Deque
     * @param mixed $e O elemento a ser adicionado
     * @return boolean Retorna TRUE caso seja adicionado com sucesso
     */
    public function offerLast($e) {
        $this->add($e);
    }

    /**
     * Recupera, mas não remove, o primeiro elemento da fila representada por 
     * essa Deque, ou retorna null se ese Deque estiver vazio
     * @return mixed|null
     */
    public function peek() {
        return $this->peekFirst();
    }

    /**
     * Recupera, mas não remove, o primeiro elemento deste LinkedList, ou retorna 
     * null se este LinkedList está vazio.
     * @return mixed|null
     */
    public function peekFirst() {
        $e = $this->getFirst();
        if ($e) {
            return $e;
        }
        return NULL;
    }

    /**
     * Recupera, mas não remove, o último elemento deste LinkedList, ou retorna 
     * null se este LinkedList está vazio.
     * @return mixed|null
     */
    public function peekLast() {
        $e = $this->getLast();
        if ($e) {
            return $e;
        }
        return NULL;
    }

    /**
     * Recupera e remove, o primeiro elemento deste LinkedList, ou retorna 
     * null se este LinkedList está vazio.
     * @return mixed|null
     */
    public function poll() {
        return $this->pollFirst();
    }

    /**
     * Recupera e remove, o primeiro elemento deste LinkedList, ou retorna 
     * null se este LinkedList está vazio.
     * @return mixed|null
     */
    public function pollFirst() {
        return array_shift($this->collection);
    }

    /**
     * Recupera e remove, o último elemento deste LinkedList, ou retorna 
     * null se este LinkedList está vazio.
     * @return mixed|null
     */
    public function pollLast() {
        return $this->pop();
    }

    /**
     * Recupera e remove o último elemento da pilha representada por este LinkedList.
     * @return mixed|NULL
     */
    public function pop() {
        return array_pop($this->collection);
    }

    /**
     * Coloca um elemento na pilha representado por este LinkedList, em outras palavras
     * no início desta Deque
     * @param mixed $e
     * @return boolean 
     */
    public function push($e) {
        $this->addFirst($e);
        return TRUE;
    }

    /**
     * Remove a primeira ocorrência do elemento especificado a partir deste LinkedList.
     * @param mixed $o
     */
    public function remove($o = NULL) {
        $this->removeObject($o);
    }

    /**
     * Recupera e remove o primeiro elemento deste LinkedList.
     * @return mixed
     * @throws NoSuchElementException Lança excessão se 
     * a lista estiver vazia
     */
    public function removeFirst() {
        if (!$this->pollFirst()) {
            throw new NoSuchElementException(__CLASS__ . ' vazia');
        }
    }

    /**
     * Remove a primeira ocorrência do elemento especificado a partir deste LinkedList.
     * @param mixed $o
     * @return boolean Retorna
     */
    public function removeFirstOccurrence($o) {
        $index = $this->indexOf($o);
        if ($index !== FALSE) {
            $this->modCount++;
            unset($this->collection [$index]);
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Recupera e remove o última elemento deste LinkedList.
     * @return mixed
     * @throws NoSuchElementException Lança excessão se a lista estiver vazia
     */
    public function removeLast() {
        if (!$this->pollLast()) {
            throw new NoSuchElementException(__CLASS__ . ' vazia');
        }
    }

    /**
     * Remove a última ocorrência do elemento especificado a partir deste LinkedList.
     * @param mixed $o
     * @return boolean
     */
    public function removeLasttOccurrence($o) {
        $a = array_reverse($this->collection, TRUE);
        $o = array_search($o, $a);
        unset($a);
        if ($o === false) {
            return false;
        }
        unset($this->collection[$o]);
        return true;
    }

    /**
     * Retorna o número de elementos desta lista
     * @return int
     */
    public function size() {
        return parent::size();
    }

    /**
     * Retorna os elementos da lista serializado
     * @return string
     */
    public function serialize() {
        return serialize($this->toArray());
    }

}
