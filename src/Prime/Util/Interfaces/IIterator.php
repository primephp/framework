<?php

namespace Prime\Util\Interfaces;

use Iterator;

/**
 * Descrição da Interface IIterator
 * @package Prime\util
 * @dateCreate 06/06/2014
 * @author comforsup-0215
 */
interface IIterator extends Iterator
{

    /**
     * Retorna TRUE se o interador possui mais elementos
     */
    public function hasNext();

    /**
     * Remove da coleção subjacente o último elemento retornado por essa 
     * iteração (operação opcional).
     */
    public function remove();

    /**
     * Retorna o elemento corrente
     */
    public function current();

    /**
     * Move para o próximo elemento
     */
    public function next();

    /**
     * Retorna a chave/índice do elemento corrent
     */
    public function key();

    /**
     * Verifica se a posição atual é válida
     */
    public function valid();

    /**
     * Retorna o iterador para o primeiro elemento
     */
    public function rewind();
}
