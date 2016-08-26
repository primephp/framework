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

namespace Prime\Util\Exception;

use RuntimeException;

/**
 * Description of NoSucElementException
 *
 * @author comforsup-0213
 */
class NoSuchElementException extends RuntimeException {

    public function __construct($message, $code = NULL, $previous = NULL) {
        parent::__construct($message, $code, $previous);
    }

}
