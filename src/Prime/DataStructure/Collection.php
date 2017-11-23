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

use Traversable;

/**
 * Collection é a interface base que abrange a funcionalidade comum a todas as 
 * estruturas de dados nesta biblioteca. Garante que todas as estruturas sejam 
 * Traversable, Countable, e podem ser convertidas para json usando json_encode().
 * @name Collection
 * @package Prime\DataStructure
 * @since 30/10/2017
 * @author TomSailor
 */
interface Collection extends Hashable, Traversable, \Countable, \JsonSerializable
{

    /**
     * Remove todos os valors
     */
    public function clear();
    
    /**
     * Retorna o tamanho da coleção
     * @return int
     */
    public function count():int;

    /**
     * Retorna uma cópia superficial da coleção
     * @return Collection Uma cópia da coleção
     */
    public function copy(): Collection;

    /**
     * Verifica se a coleção está vazia
     * @return bool 
     */
    public function isEmpty(): bool;

    /**
     * Retorna um array representando a coleção
     * @return array
     */
    public function toArray(): array;
}
