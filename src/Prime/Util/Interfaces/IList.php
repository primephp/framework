<?php

/*
 * Copyright (C) 2014 tom
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Prime\Util\Interfaces;

/**
 * Interface que extende Collection, e que define coleções ordenadas 
 * (sequências), onde se tem o controle total sobre a posição de cada elemento, 
 * identificado por um índice numérico. Na maioria dos casos, pode ser encarado 
 * como um "array de tamanho variável" pois, como os arrays primitivos, é 
 * acessível por índices, mas além disso possui métodos de inserção e remoção.
 * @author tom
 */
interface IList extends ICollection {

    /**
     * Insere o elemento especificado na posição especificada nesta lista.
     * @param int $index
     * @param mixed $element
     */
    public function addIn($index, $element);

    /**
     * Retorna o elemento na posição especificada na lista.
     * @param int $index
     */
    public function getIn($index);

    /**
     * Retorna o índice da primeira ocorrência do elemento especificado na lista,
     *  ou -1 se esta lista não contém o elemento.
     * @param mixed $o
     */
    public function indexOf($o);

    /**
     * Retorna o índice da última ocorrência do elemento especificado na lista, 
     * ou -1 se esta lista não contém o elemento.
     * @param mixed $o
     */
    public function lastIndexOf($o);

    /**
     * Substitui o elemento na posição especificada na lista com o elemento 
     * especificado (operação opcional).
     * @param int $index
     * @param mixed $element
     */
    public function set($index, $element);

    /**
     * Retorna uma visão da parte desta lista entre o fromIndex especificada, 
     * inclusive, e toIndex, exclusivo.
     * @param int $fromIndex
     * @param int $toIndex
     */
    public function subList($fromIndex, $toIndex);
}
