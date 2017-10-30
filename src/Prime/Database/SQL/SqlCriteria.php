<?php

/*
 * The MIT License
 *
 * Copyright 2017 Elton Luiz.
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

use Prime\Core\TString;
use Prime\Util\Collection\ArrayObject;

/**
 * A classe SqlCriteria é usada para implementar filtros, definindo condições específicas
 * para atingir apenas determinados registros em uma instrução SQL
 *
 * @author Elton Luiz
 */
class SqlCriteria extends AbstractExpression
{

    /**
     * Armazena todos os filtros adicionados
     * @var ExpressionInterface[]
     */
    private $expression;

    /**
     * Armazena todos operadores atinentes aos filtros adicionados
     * @var string[]
     */
    private $operator;

    /**
     * SqlCritéria implementa filtros para uma instrução SQL
     */
    public function __construct()
    {
        $this->expression = new ArrayObject();
        $this->operator = new ArrayObject();
    }

    /**
     * Reseta todos os critérios da instrução SQL
     */
    public function reset()
    {
        $this->expression->clear();
        $this->operator->clear();
    }

    /**
     * Adiciona um critério de filtro
     * @param ExpressionInterface $criteria
     * @param string $operator
     */
    public function add(ExpressionInterface $criteria, string $operator = self::AND_OPERATOR)
    {
        if ($this->expression->size() == 0) {
            $operator = NULL;
        }
        $this->addFilter($criteria);
        $this->addFilterOperator($operator);
    }

    /**
     * Adiciona o filtro de critério
     * @param ExpressionInterface $filter
     */
    private function addFilter(ExpressionInterface $filter)
    {
        $this->expression->add($filter);
    }

    /**
     * Adiciona o operador lógico para o filtro de critério
     * @param string $operator
     */
    private function addFilterOperator($operator = NULL)
    {
        $this->operator->add($operator);
    }

    /**
     * {@inheritDoc}
     */
    public function dump(): string
    {
        $string = new TString('(');

        if (!count($this->expression)) {
            throw new \RuntimeException(__CLASS__ . ' sem filtros definidos');
        }
        foreach ($this->expression as $key => $value) {
            $string->concat($this->operator->offsetGet($key));
            $string->concat($value->dump());
        }
        $string->trim();
        $string->concat(')');
        return $string->getValue();
    }

}
