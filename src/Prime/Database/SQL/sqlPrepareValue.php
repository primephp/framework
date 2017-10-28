<?php

/*
 * The MIT License
 *
 * Copyright 2017 85101346.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Prime\Database\SQL;

use Prime\Core\Exceptions\InvalidParamException;

/**
 * @name sqlPrepareValue
 * @package Prime\Database\SQL
 * @since 28/10/2017
 * @author TomSailor
 */
trait sqlPrepareValue {

    /**
     * Retorna uma string caso o objeto tenha método conhecido para retornar
     * seu valor como string
     * @param object $object
     * @return string
     * @throws InvalidParamException Lança uma exceção caso o objeto não possa 
     * ser convertido para uma string
     */
    private function isObject($object) {
        $value = '';
        if (method_exists($object, '__toString')) {
            $value = (string) $object;
        } else if (method_exists($object, 'toString')) {
            $value = $object->toString();
        } else {
            throw new InvalidParamException("Parâmetro $object é inválido em " . get_called_class());
        }
        return $value;
    }

    /**
     * Se o valor for do tipo scalar retorna o mesmo numa string válida para
     * inserção no SGBD
     * @param mixed $value
     * @return string
     */
    private function isScalar($value) {
        if (is_string($value) && !empty($value)) {
            $value = addslashes($value);
            $value = "'$value'";
        } elseif (is_bool($value)) {
            $value = $value ? 'TRUE' : 'FALSE';
        } elseif ($value !== '') {
            $value = $value;
        } else {
            $value = 'NULL';
        }
        return $value;
    }

    /**
     * Prepara o valor passado para ser do tipo válido para inserção em um SGBD 
     * retornando-o como uma string válida
     * @param mixed $value O valor a ser preparado
     * @return string Uma string válida para inserção no SGBD
     */
    protected function prepareValue($value) {
        if (is_object($value)) {
            $value = $this->isObject($value);
        }
        if (is_scalar($value)) {
            $value = $this->isScalar($value);
        }
        return $value;
    }

}
