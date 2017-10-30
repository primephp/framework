<?php

/*
 * The MIT License
 *
 * Copyright 2017 TomSailor.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software");, to deal
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
 * Sequence descreve o comportamento de valores dispostos em uma única dimensão 
 * linear. Pode ser visto também como uma lista. É semelhante a um array que usa
 * chaves inteiras incrementais, com exceção de algumas características:<br>
 * - Os valores serão sempre indexados como [0, 1, 2, ..., tamanho - 1].<br>
 * - Só é permitido acessar os valores por índice no intervalo [0, tamanho - 1].
 * @name Sequence
 * @package Prime\DataStructure
 * @since 30/10/2017
 * @author TomSailor
 */
interface Sequence
{

    public function allocate(int $capacity);

    public function apply(callable $callback);

    public function capacity(): int;

    public function contains(...$values): bool;

    public function filter(callable $callback): Sequence;

    public function find($value);

    public function first();

    public function get(int $index);

    public function insert(int $index, ...$values);

    public function join(string $glue): string;

    public function last();

    public function map(callable $callback): Sequence;

    public function merge($values): Sequence;

    public function pop();

    public function push(...$values);

    public function reduce(callable $callback, $initial = 0);

    public function remove(int $index);

    public function reverse();

    public function reversed(): Sequence;

    public function rotate(int $rotations);

    public function set(int $index, $value);

    public function shift();

    public function slice(int $index, int $length = 0): Sequence;

    public function sort(callable $comparator);

    public function sorted(callable $comparator): Sequence;

    public function sum();

    public function unshift($values);
}
