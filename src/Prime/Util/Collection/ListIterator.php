<?php

/*
 * Copyright (C) 2014 comforsup-0213 This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Prime\Util\Collection;

use Prime\Util\Exception\NoSuchElementException;
use Prime\Util\Interfaces\IListIterator;

/**
 * Define um iterador para listas de coleções de elementos
 * @dateCreate 16/06/2014
 * @author Elton Luiz
 */
class ListIterator extends AbstractIterator implements IListIterator
{

    public function __construct(AbstractList $list)
    {
        parent::__construct($list);
    }

    /**
     * Retorna o índice do elemento que seria retornado por uma chamada subsequente
     * ao previous()
     * @return int O índice anterior a posição atual do ponteiro. 
     */
    public function previousIndex()
    {
        return $this->key() - 1;
    }

    /**
     * Retorna true se o iterador de lista tem mais elementos ao atravessar a
     * lista no sentido inverso.
     * 
     * @return boolean
     */
    public function hasPrevious()
    {
        if ($this->previousIndex() < 0) {
            return FALSE;
        }
        if ($this->offsetExists($this->previousIndex())) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Move para o elemento anterior
     */
    public function previous()
    {
        $this->seek($this->previousIndex());
    }

    public function getPrevious()
    {
        if ($this->hasPrevious()) {
            $this->previous();
            return $this->current();
        } else {
            throw new NoSuchElementException('Não há mais elemento, o Iterador ja ' . 'no limite inicial da Lista');
        }
    }

}
