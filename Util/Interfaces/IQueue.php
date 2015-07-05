<?php

/*
 * Copyright (C) 2014 comforsup-0213
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

use Prime\Core\Interfaces\IIterable;

/**
 * Descrição da Interface IQueue
 * @package Prime\util;
 * @dateCreate 10/06/2014
 * @author Elton Luiz
 */
interface IQueue extends ICollection, IIterable {

    /**
     * Insere o elemento especificado para esta fila se for possível fazê-lo imediatamente, 
     * sem violar as restrições de capacidade, retornando true em caso de sucesso e 
     * lançar uma IllegalStateException se não houver espaço disponível no momento.
     * @return TBoolean 
     */
    public function add($e);

    /**
     * Recupera, mas não remove, o chefe desta fila.
     */
    public function element();

    /**
     * Insere o elemento especificado para esta fila se for possível fazê-lo 
     * imediatamente, sem violar as restrições de capacidade.
     */
    public function offer($e);

    /**
     * Recupera, mas não remove, a cabeça desta fila, ou retorna null se esta fila é empty.E
     */
    public function peek();

    /**
     * Recupera e remove o cabeça desta fila, ou retorna null se esta fila está vazia.
     */
    public function poll();

    /**
     * Recupera e remove o elemento superior da fila
     */
    public function remove();
}
