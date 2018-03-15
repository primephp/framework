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

use Prime\Util\Collection\ArrayObject;

/**
 * @name SqlGroupBy
 * @package Prime\Database\SQL
 * @since 29/10/2017
 * @author TomSailor
 */
class SqlGroupBy extends AbstractExpression
{

    /**
     * Um array que armazena todas os nomes de campos que formaram a cláusula
     * order by da instrução SQL
     * @var ArrayObject
     */
    private $struct;

    /**
     * Cria um objeto para definir as colunas de agrupamaneto de uma instrução
     * SQL
     * @param string $column Coluna a ser adicionada
     * @param string $columns
     */
    public function __construct($column, ...$columns)
    {
        $this->struct = new ArrayObject();
        $this->add($column);
        if (is_array($columns)) {
            foreach ($columns as $field) {
                $this->add($field);
            }
        }
    }

    /**
     * Adiciona uma coluna para agrupamento
     * @param string $column nome do campo(coluna) a ser adicionado
     */
    public function add($column)
    {
        $this->struct->add($column);
    }

    /**
     * {@inheritDoc}
     */
    public function dump(): string
    {
        if (!$this->struct->isEmpty()) {
            return implode(', ', $this->struct->toArray());
        }
    }

}
