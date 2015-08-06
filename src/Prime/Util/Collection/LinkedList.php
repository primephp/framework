<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Util\Collection;

use Prime\core\interfaces\IClonable;
use Prime\io\interfaces\ISerializable;
use Prime\Util\Interfaces\IDeque;
use Prime\Util\Interfaces\IList;

/**
 * Descrição de LinkedList
 * Implementação da lista duplamente vinculada das interfaces Lista e deque. 
 * Implementa todas as operações de lista opcional, e permite que todos os 
 * elementos (incluindo nulo).
 * Todas as operações de realizar como poderia ser esperado de uma lista 
 * duplamente ligado. Operações que índice para a lista irá percorrer a lista 
 * desde o início ou o fim, o que for mais perto do índice especificado. 
 * @author tom
 */
class LinkedList extends AbstractSequentialList implements IList, IDeque, IClonable, ISerializable
{

    public function addFirst($e)
    {
        
    }

    public function addLast($e)
    {
        
    }

    public function element()
    {
        
    }

    public function getClone()
    {
        
    }

    public function getFirst()
    {
        
    }

    public function offer($e)
    {
        
    }

    public function offerLast($e)
    {
        
    }

    public function peek()
    {
        
    }

    public function peekFirst()
    {
        
    }

    public function poll()
    {
        
    }

    public function pollFirst()
    {
        
    }

    public function removeFirst()
    {
        
    }

    public function serialize()
    {
        
    }

    public function subList($fromIndex, $toIndex)
    {
        
    }

}
