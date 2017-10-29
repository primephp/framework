<?php

/*
 * The MIT License
 *
 * Copyright 2017 quantum.
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
 * Description of Filter
 *
 * @author Tom Sailor
 */
class SqlFilter extends AbstractExpression {

    use sqlSanitizeValue;

    /**
     * Nome do campo a ser utilizado no filtro
     * @var string 
     */
    private $variable;

    /**
     * Operador relacional a ser utilizado no filtro
     * @var string 
     */
    private $operator;

    /**
     * Valor para ser comparado no campo definido
     * @var string
     */
    private $value;

    public function __construct($field, $operator, $value) {
        $this->setField($field);
        $this->setOperator($operator);
        $this->setValue($value);
    }

    private function setField($field) {
        if ($field instanceof SqlColumn) {
            $field = $field->getName();
        }
        if (is_string($field)) {
            $this->variable = $field;
        } else {
            throw new InvalidParamException("$field não é nome de campo válido");
        }
    }

    private function setOperator($operator) {
        if (in_array($operator, [
                    self::EQUALS,
                    self::GREATER_THAN,
                    self::LESS_THAN,
                    self::GREATER_THAN_OR_EQUAL_TO,
                    self::LESS_THAN_OR_EQUAL_TO,
                    self::NOT_EQUAL_TO,
                    self::BETWEEN,
                    self::LIKE,
                    self::IN,
                    self::NOT_IN,
                    self::IS
                ])) {
            $this->operator = $operator;
        } else {
            throw new InvalidParamException("$operator não é um tipo de operador de comparação SQL válido");
        }
    }

    private function setValue($value) {
        $this->value = $this->sanitizeValue($value);
    }

    /**
     * {$inheritDoc}
     */
    public function dump(): string {
        return "{$this->variable} {$this->operator} {$this->value}";
    }

}
