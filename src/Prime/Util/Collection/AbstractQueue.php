<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Util\Collection;

use Prime\Util\Exception\NoSuchElementException;
use Prime\Util\Interfaces\IQueue;

/**
 * Descrição da Classe AbstractQueue
 * @name AbstractQueue
 * @package Prime\Util\Collection
 * @author Tom Sailor
 * @create 13/08/2016
 */
abstract class AbstractQueue extends AbstractCollection implements IQueue
{

    /**
     * Adiciona o elemento na fila
     * @param mixed $e
     */
    public function add($e)
    {
        parent::add($e);
    }

    /**
     * Insere o elemento especificado na fila
     * @param mixed $e
     */
    public function offer($e)
    {
        $this->add($e);
    }

    /**
     * Retorna e remove o primeiro elemento da fila, caso a fila esteja vazia 
     * lança uma excessão
     * @return type
     * @throws NoSuchElementException
     */
    public function remove()
    {
        if (!$this->size()) {
            throw new NoSuchElementException('A fila está vazia');
        }
        return array_shift($this->collection);
    }

    /**
     * Retorna e remove o primeiro elemento da fila, caso a fila esteja vazia
     * retorn NULL
     * @return mixed|NULL
     */
    public function poll()
    {
        return array_shift($this->collection);
    }

    /**
     * Retorna o primeiro elemento da fila, porém não remove o elemento da mesma
     * @return mixed
     * @throws NoSuchElementException
     */
    public function element()
    {
        if (!$this->size()) {
            throw new NoSuchElementException('A fila está vazia');
        }
        reset($this->collection);
        return current($this->collection);
    }

    /**
     * Retorna, porém não remove o primeiro elemento da fila
     * @return mixed
     */
    public function peek()
    {
        if (!$this->size()) {
            return NULL;
        }
        reset($this->collection);
        return current($this->collection);
    }

    abstract function iterator();
}
