<?php

/*
 * Copyright (C) 2014 Elton Luiz
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
 * A interface de raiz na hierarquia coleção. A coleção representa um grupo de 
 * objetos, conhecidos como seus elementos. Algumas coleções permitem elementos 
 * duplicados e outros não. Alguns são ordenados e os outros não ordenada. 
 * @author tom
 */
interface ICollection extends IIterable {

    public function add($e);

    public function addAll(ICollection $collection);

    public function clear();

    public function contains($o);

    public function containAll(ICollection $collection);

    public function equals(ICollection $collection);

    public function hashCode();

    public function isEmpty();

    public function remove($o);

    public function removeAll(ICollection $collection);

    public function retainAll(ICollection $collection);

    public function size();

    public function toArray();

    public function toArrayList();

    public function toArrayObject();
}
