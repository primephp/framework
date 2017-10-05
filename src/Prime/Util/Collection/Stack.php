<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Util\Collection;

/**
 * Descrição de Stack
 *
 * @author Elton Luiz
 */
class Stack extends Vector
{

    /**
     * Verifica se o vetor tem elementos
     * @return boolean Retorna <b>TRUE</b> caso não haja elementos e FALSE se 
     * o vetor possuir elementos
     */
    public function isEmpty()
    {
        if (!$this->size()) {
            return true;
        }
        return false;
    }

    /**
     * Retorna o elemento do topo da pilha
     * @return mixed|NULL
     */
    public function peek()
    {
        end($this->collection);
        return current($this->collection);
    }

    /**
     * Remove o elemento do topo da pilha e retorna o elemento
     * @return mixed|NULL
     */
    public function pop()
    {
        return array_pop($this->collection);
    }

    /**
     * Adiciona o elemento no topo da pilha
     * @param mixed $item
     * @return int O total de elementos da pilha
     */
    public function push($item)
    {
        return $this->add($item);
    }

    /**
     * Retorna a distância do elemento desde o topo da pilha, sendo 1 o topo e 
     * assim sucessivamente e -1 caso não esteja na pilha
     * @param mixed $o O elemento a ser localizado na pilha
     * @return int A posição desde o topo da pilha e <b>-1</b> se não houver
     */
    public function search($o)
    {
        $p = array_search($o, $this->collection);
        if ($p === false) {
            return -1;
        }
        $t = $this->size();
        return (int) ((int) $t - (int) $p);
    }

}
