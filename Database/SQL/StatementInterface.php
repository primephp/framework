<?php

/*
 * The MIT License
 *
 * Copyright 2017 wwwel.
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
 * @name StatementInterface
 * @package Prime\Database\SQL
 * @since29/10/2017
 * @author Tom Sailor
 */
interface StatementInterface
{

    /**
     * Define o nome da entidade (tabela) que será manipulada
     * @param string $entity O nome da entidade (tabela) que será manipulada
     * @throws InvalidParamException Caso o valor de $entity não seja uma string válida
     */
    public function setEntity(string $entity);

    /**
     * Retorna o nome da entidade (tabela) do SQL que será manipulada pela 
     * instrução SQL.
     * @return string
     * @throws InvalidParamException Caso não tenha sido definido o nome da tabela
     */
    public function getEntity(): string;

    /**
     * Retorna a instrução SQL
     * @return string A instrução SQL
     */
    public function getStatement(): string;
}
