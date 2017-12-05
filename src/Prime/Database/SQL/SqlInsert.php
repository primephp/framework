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

use Prime\Core\Exceptions\InvalidContextException;
use Prime\Core\TString;

/**
 * @name SqlInsert
 * @package Prime\Database\SQL
 * @since 05/12/2017
 * @author TomSailor
 */
class SqlInsert extends AbstractStatement {

    use SqlCriteriaExpression;
    use SqlColumnDataTrait;

    /**
     * {@inheritDoc} 
     */
    public function getStatement(): string {
        $columns = implode(', ', array_keys($this->columnsValues));
        $values = implode(', ', array_values($this->columnsValues));

        $string = new TString("INSERT INTO {$this->getEntity()} ");
        $string->concat("($columns)");
        $string->concat(" values ($values)");
        $this->statement = $string->getValue();
        return $this->statement;
    }

    public function setCriteria(SqlExpressionInterface $criteria) {
        throw new InvalidContextException(__CLASS__ . ' não aceita definição de Critério');
    }

}
