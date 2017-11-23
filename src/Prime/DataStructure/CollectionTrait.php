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

namespace Prime\DataStructure;

/**
 * @name CollectionTrait
 * @package Prime\DataStructure
 * @since 22/11/2017
 * @author TomSailor
 * Características comuns para classes que implementam a interface Collection
 */
trait CollectionTrait
{
    use HashableTrait;

    /**
     * Retorna se a coleção está vazia.
     *
     * Isso deve ser equivalente a uma contagem de zero, mas não é necessário.
     * As implementações devem definir o que significa vazio em seu próprio contexto.
     *
     * @return bool Se a coleção está vazia
     */
    public function isEmpty(): bool
    {
        return count($this) === 0;
    }

    /**
     * Retorna uma representação do objeto que pode ser nativamente convertida
     * para JSON, que é chamada pela função json_encode
     * @return string
     *
     * @see JsonSerializable
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Cria uma cópia superficial da coleção
     *
     * @return Collection Uma cópia superficial da coleção
     */
    public function copy(): Collection
    {
        return new self($this);
    }

    /**
     * Retorna um array representando a coleção
     *
     * O formato da matriz retornada é dependente da implementação. Algumas 
     * implementações podem lançar uma exceção se uma representação de matriz 
     * não puder ser criada (por exemplo, quando o objeto é usado como chaves).
     *
     * @return array
     */
    abstract public function toArray(): array;

    /**
     * Método invocado ao chamar var_dump
     *
     * @return array
     */
    public function __debugInfo()
    {
        return $this->toArray();
    }

    /**
     * Retorna uma representação de string da coleção, que é invocada quando a coleção é convertida em uma string.
     * 
     * @return string
     */
    public function __toString()
    {
        return 'object(' . get_class($this) . ')';
    }

}
