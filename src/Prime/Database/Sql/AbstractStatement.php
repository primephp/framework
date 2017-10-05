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

namespace Prime\Database\Sql;

use Prime\Core\Exceptions\InvalidParamException;

/**
 * Descrição de AbstractStatement
 * Classe Abstrata que provê os métodos comuns entre todas as intruções SQL
 * (SELECT, INSERT, DELETE e UPDATE)
 * @author Elton Luiz
 */
abstract class AbstractStatement
{

    /**
     * Armazena a instrução sql utilizada pelo objeto SQL
     * @var string Instrução SQL
     */
    protected $statement;

    /**
     * Armazena o nome da entidade (tabela) que será manipulada pela instrução
     * SQL
     * @var string Nome da Tabela 
     */
    protected $entity;

    /**
     * Define o nome da entidade (tabela) que será manipulada
     * @param string $entity O nome da entidade (tabela) que será manipulada
     * @throws InvalidParamException Caso o valor de $entity não seja uma string válida
     */
    public function setEntity($entity)
    {
        if (is_string($entity)) {
            $this->entity = $entity;
        } else {
            throw new InvalidParamException('O valor para $entity deve ser uma string válida');
        }
    }

    /**
     * Retorna o nome da entidade (tabela) que será manipulada pela instrução SQL, 
     * ou NULL caso não tenha sido definida
     * @return string|NULL O nome da entidade ou null caso não tenha sido definida
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Retorna a instrução SQL
     * @return string A instrução SQL
     */
    abstract public function getStatement();
}
