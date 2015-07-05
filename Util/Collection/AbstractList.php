<?php

/*
 * Copyright (C) 2014 tom This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Prime\Util\Collection;

use Prime\Util\Interfaces\IList;

/**
 * Descrição de AbstractList
 *
 * @author tom
 */
abstract class AbstractList extends AbstractCollection implements IList {

    public function addIn($index, $element) {
        $this->_collection [$index] = $element;
    }

    public function removeIn($index) {
        if (isset($this->_collection [$index])) {
            unset($this->_collection[$index]);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get($index) {
        if (isset($this->_collection [$index])) {
            return $this->_collection [$index];
        }
    }

    public function indexOf($o) {
        return array_search($o, $this->_collection);
    }

    public function lastIndexOf($o) {
        $array = array_reverse($this->_collection, TRUE);
        return array_search($o, $array);
    }

    public function removeObject($o) {
        $index = $this->indexOf($o);
        if ($index !== FALSE) {
            unset($this->_collection [$index]);
        }
    }

    /**
     * Remove da lista de todos os elementos cujo índice está entre fromIndex, 
     * inclusive, e toIndex, exclusivo. Desloca os elementos seguintes para a 
     * esquerda (reduz o seu índice). Esta chamada encurta a lista 
     * (toIndex - fromIndex) elementos
     * @param type $fromIndex
     * @param type $toIndex
     */
    public function removeRange($fromIndex, $toIndex) {
        for ($index = $fromIndex; $index < $toIndex; $index++) {
            $this->removeIn($index);
        }
    }

    public function set($index, $element) {
        $this->_collection [$index] = $element;
    }

}
