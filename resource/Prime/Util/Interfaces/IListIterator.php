<?php

namespace Prime\Util\Interfaces;

/*
 * Copyright (C) 2014 comforsup-0212
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

/**
 * Descrição da Interface IListIterator
 * @dateCreate 09/06/2014
 * @author Elton Luiz
 */
interface IListIterator extends IIterator {

    /**
     * Insere o elemento especificado na lista
     * @param mixed $e
     */
    public function add($e);

    /**
     * Retorna true se o iterador de lista tem mais elementos ao atravessar a 
     * lista na frente.
     */
    public function hasNext();

    /**
     * Retorna true se o iterador de lista tem mais elementos ao atravessar a 
     * lista no sentido inverso.
     */
    public function hasPrevious();

    /**
     * Avança a posição do cursor para o próximo elemento
     */
    public function next();

    /**
     * Retorna o próximo índice
     */
    public function nextIndex();

    /**
     * Move a posição do cursor para trás.
     */
    public function previous();

    /**
     * Retorna a posição anterior do cursos
     */
    public function previousIndex();

    /**
     * Remove da lista o último elemento corrente
     */
    public function remove();

    /**
     * Substitui o último elemento da posição corrente do cursor
     * @param mixed $e
     */
    public function set($e);
}
