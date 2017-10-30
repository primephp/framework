<?php

/*
 * The MIT License
 *
 * Copyright 2017 TomSailor.
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

/**
 * @name SqlColumnDataTrait
 * @package Prime\Database\SQL
 * @since29/10/2017
 * @author TomSailor
 */
trait SqlColumnDataTrait
{

    use SqlPrepareValueTrait;

    /**
     * @var array
     */
    private $columnsValues;

    /**
     * Define o valor para a coluna
     * @param string $column
     * @param mixed $value
     */
    public function setColumnData(string $column, $value)
    {
        $this->columnsValues[$column] = $this->prepareValue($value);
    }

    /**
     * Retorna o valor definido para a respectiva coluna
     * @param string $name O nome da coluna 
     * @return string O valor da coluna
     */
    public function getColumnValue($name)
    {
        return $this->columnsValues[$name];
    }

    /**
     * Retorna returna uma string referente a coluna no padrão "column = value"
     * @param string $name O nome da coluna
     * @return string Uma string contendo column = value
     */
    public function getColumnSet(string $name): string
    {
        if (isset($this->columnsValues[$name])) {
            return "{$name} = {$this->columnsValues[$name]}";
        }
    }

    /**
     * Retorna um objeto array contendo todas colunas e seus respectivos valores
     * @return array
     */
    private function getColumns(): array
    {
        return $this->columnsValues;
    }

}
