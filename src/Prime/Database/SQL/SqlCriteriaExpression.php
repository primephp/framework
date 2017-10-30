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

use Prime\Database\SQL\ExpressionInterface as ExpressionInterface;

/**
 * @name SqlCriteriaExpression
 * @package Prime\Database\SQL
 * @since 29/10/2017
 * @author TomSailor
 */
trait SqlCriteriaExpression
{

    /**
     * @var ExpressionInterface
     */
    private $criteria;

    /**
     * Define os critérios para a consulta
     * @param ExpressionInterface $criteria
     * @return $this
     */
    public function setCriteria(ExpressionInterface $criteria)
    {
        $this->criteria = $criteria;
        return $this;
    }

    /**
     * Retorna o objeto de critério
     * @return ExpressionInterface
     */
    public function getCriteria(): ExpressionInterface
    {
        return $this->criteria;
    }

}
