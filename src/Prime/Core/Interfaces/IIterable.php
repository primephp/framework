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

namespace Prime\core\interfaces;

use Prime\Util\Interfaces\IIterator;

/**
 * Define uma interface para objetos que possam ser iteráveis
 * @author tom
 */
interface IIterable
{

    /**
     * Retorna um iterador sobre um conjunto de elementos do Tipo X
     * @return IIterator Um Iterador com a interface de IITerator
     */
    public function iterator();
}
