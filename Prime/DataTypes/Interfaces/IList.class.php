<?php

namespace Prime\DataTypes\Interfaces;

/**
 *
 * @package Prime\DataTypes\Interfaces
 * @author Tom Sailor
 */
interface IList {

    /**
     * Retorna o número de objetos da lista 
     */
    public function count();

    /**
     * Retorna o objeto situado em um índice determinado 
     */
    public function get($index);

    /**
     * Retorna o primeiro objeto da lista 
     */
    public function first();

    /**
     * Retorna o último objeto da lista 
     */
    public function last();

    /**
     * Acrescenta o ítem a lista tornando-o o seu último elemento
     */
    public function append($item);

    /**
     * Acrescenta o ítem a lista tornando-o o seu primeiro elemento 
     */
    public function prepend($item);

    /**
     * Remove um determinado elemento da lista, situado no índice determinado 
     */
    public function remove($index);

    /**
     * Remove o primeiro elemento da lista 
     */
    public function removeFirst();

    /**
     * Remove o último elemento da lista 
     */
    public function removeLast();

    /**
     * Remove todos os elementos da lista 
     */
    public function removeAll();
}
