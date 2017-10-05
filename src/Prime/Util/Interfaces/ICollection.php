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
 * Interface base para todos os tipos de coleção, a Interface raiz na hierarquia
 * das coleções. Uma coleção representa um grupo de objetos, com seus elementos
 * conhecidos. Ela define as operações mais básicas para coleções de objetos, 
 * como adição (add) e remoção (remove) abstratos (sem informações quanto à 
 * ordenação dos elementos), esvaziamento (clear), tamanho (size), conversão 
 * para array (toArray), objeto de iteração (iterator), e verificações de 
 * existência (contains e isEmpty).
 * @author 
 */
interface ICollection extends IIterable
{

    public function add($e);

    public function addAll(ICollection $collection);

    public function clear();

    public function contains($o);

    public function containAll(ICollection $collection);

    public function hashCode();

    public function isEmpty();

    public function remove($o);

    public function removeAll(ICollection $collection);

    public function retainAll(ICollection $collection);

    public function size();

    public function toArray();

    public function toArrayObject();
}
