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
     * @param type $e
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
     * Retorna o próximo elemento da lista e avança a posição do cursor.
     */
    public function next();

    /**
     * Retorna o índice do elemento que seria devolvido por uma chamada 
     * subseqüente a next ().
     */
    public function nextIndex();

    /**
     * Retorna o elemento anterior da lista e move a posição do cursor
     * para trás.
     */
    public function previous();

    /**
     * Retorna o índice do elemento que seria retornado por uma chamada subsequente
     * ao previous()
     */
    public function previousIndex();

    /**
     * Remove da lista o último elemento retornado por next() ou previous()
     */
    public function remove();

    /**
     * Substitui o último elemento retornado por next() ou previous() pelo 
     * elemento especificado
     * @param type $e
     */
    public function set($e);
}

?>
