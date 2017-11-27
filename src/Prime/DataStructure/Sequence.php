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

use OutOfRangeException;
use Traversable;
use UnderflowException;

/**
 * Sequence descreve o comportamento de valores dispostos em uma única dimensão 
 * linear. Pode ser visto também como uma Lista. É semelhante a um array que usa
 * chaves inteiras incrementais, com exceção de algumas características:<br>
 * - Os valores serão sempre indexados como [0, 1, 2, ..., tamanho - 1].<br>
 * - Só é permitido acessar os valores por índice no intervalo [0, tamanho - 1].
 * @name Sequence
 * @package Prime\DataStructure
 * @since 30/10/2017
 * @author TomSailor
 */
interface Sequence extends Collection
{

    /**
     * 
     * Atualiza todos os valores da sequência(Lista) aplicando uma função callback,
     * usando o valor de retorno como o novo valor
     *
     * @param callable $callback retorna o novo valor
     */
    function apply(callable $callback);

    /**
     * Determina se a sequência(Lista) contém todos os valores de zero ou mais
     *
     * @param mixed ...$values
     *
     * @return bool TRUE Se pelo menos um valor foi fornecido e a sequência(Lista)
     * contém os valores passados
     */
    function contains(...$values): bool;

    /**
     * Retorna uma nova Sequência(Lista) contento apenas os valores para os quais
     * a função callback retorna TRUE. Um teste boleano será usado se um retorno
     * de chamada não for fornecido
     * @param callable|null $callback Aceita um valor, retorna um resultado boleano:
     *                                true : inclui o valor,
     *                                false: pula o valor.
     *
     * @return Sequence
     */
    function filter(callable $callback = null): Sequence;

    /**
     * Retorna o índice de um determinado valor ou FALSE se não for encontrado
     *
     * @param mixed $value
     *
     * @return int|bool
     */
    function find($value);

    /**
     * Retorna o primeiro valor da Sequência(Lista)
     *
     * @return mixed
     *
     * @throws UnderflowException Se a Sequência(Lista) estiver vazia.
     */
    function first();

    /**
     * Retorna o valor em um determinado índice (posição) na Seqüência(Lista).
     *
     * @param int $index
     *
     * @return mixed
     *
     * @throws OutOfRangeException se o índice não estiver no intervalo [0, size-1]
     */
    function get(int $index);

    /**
     * Insere zero ou mais valores em um determinado índice.
     *
     * Cada valor após o índice será movido uma posição para a direita.
     * Os valores podem ser inseridos em um índice igual ao tamanho da seqüência.
     *
     * @param int   $index
     * @param mixed ...$values
     *
     * @throws OutOfRangeException se o índice não estiver no intervalo [0, n]
     */
    function insert(int $index, ...$values);

    /**
     * Junta todos os valores da seqüência em uma string, adicionando uma 
     * "cola(glue)" opcional entre eles. Retorna uma seqüência vazia se a 
     * seqüência estiver vazia.
     *
     * @param string $glue
     *
     * @return string
     */
    function join(string $glue = null): string;

    /**
     * Retorna o último valor da Sequência(Lista)
     *
     * @return mixed
     *
     * @throws UnderflowException Se a Sequência(Lista) estiver vazia
     */
    function last();

    /**
     * Retorna uma nova sequencia usando o resultado da função callback aplicada
     * em casa valor
     *
     * @param callable $callback
     *
     * @return Sequence
     */
    function map(callable $callback): Sequence;

    /**
     * Retorna o resultado a adição de todos os valores do sequência passada como
     * parâmetro
     *
     * @param array|Traversable $values
     *
     * @return Sequence
     */
    function merge($values): Sequence;

    /**
     * Remove o último valor da sequência e retorna-o
     *
     * @return mixed O último valor da Sequência
     *
     * @throws UnderflowException Se a sequência(Lista) estiver vazia.
     */
    function pop();

    /**
     * Adiciona zero ou mais valores no final da sequencia
     *
     * @param mixed ...$values
     */
    function push(...$values);

    /**
     * Reduz a Sequência(Lista) para um único valor através de um processo 
     * iterativo via função callback.
     *
     * @param callable $callback Accepts the $carry (Valor da iteração anterior)
     * e varor $current, e retorna o valor da iteração $carry atualizado.
     *
     * @param mixed|null $initial Se o argumento opcional initial for passado, 
     * ele será utilizado no início do processo, ou como um resultado final se a
     * Sequência(Lista) estiver vazia.
     *
     * @return mixed O varor $carry (de transporte) da iteração final ou o valor
     * inicial.
     */
    function reduce(callable $callback, $initial = null);

    /**
     * Removes and returns the value at a given index in the sequence.
     *
     * @param int $index this index to remove.
     *
     * @return mixed the removed value.
     *
     * @throws OutOfRangeException if the index is not in the range [0, size-1]
     */
    function remove(int $index);

    /**
     * Reverses the sequence in-place.
     */
    function reverse();

    /**
     * Returns a reversed copy of the sequence.
     *
     * @return Sequence
     */
    function reversed();

    /**
     * Rotates the sequence by a given number of rotations, which is equivalent
     * to successive calls to 'shift' and 'push' if the number of rotations is
     * positive, or 'pop' and 'unshift' if negative.
     *
     * @param int $rotations The number of rotations (can be negative).
     */
    function rotate(int $rotations);

    /**
     * Replaces the value at a given index in the sequence with a new value.
     *
     * @param int   $index
     * @param mixed $value
     *
     * @throws OutOfRangeException if the index is not in the range [0, size-1]
     */
    function set(int $index, $value);

    /**
     * Removes and returns the first value in the sequence.
     *
     * @return mixed what was the first value in the sequence.
     *
     * @throws UnderflowException if the sequence was empty.
     */
    function shift();

    /**
     * Returns a sub-sequence of a given length starting at a specified index.
     *
     * @param int $index  If the index is positive, the sequence will start
     *                    at that index in the sequence. If index is negative,
     *                    the sequence will start that far from the end.
     *
     * @param int $length If a length is given and is positive, the resulting
     *                    sequence will have up to that many values in it.
     *                    If the length results in an overflow, only values
     *                    up to the end of the sequence will be included.
     *
     *                    If a length is given and is negative, the sequence
     *                    will stop that many values from the end.
     *
     *                    If a length is not provided, the resulting sequence
     *                    will contain all values between the index and the
     *                    end of the sequence.
     *
     * @return Sequence
     */
    function slice(int $index, int $length = null): Sequence;

    /**
     * Sorts the sequence in-place, based on an optional callable comparator.
     *
     * @param callable|null $comparator Accepts two values to be compared.
     *                                  Should return the result of a <=> b.
     */
    function sort(callable $comparator = null);

    /**
     * Returns a sorted copy of the sequence, based on an optional callable
     * comparator. Natural ordering will be used if a comparator is not given.
     *
     * @param callable|null $comparator Accepts two values to be compared.
     *                                  Should return the result of a <=> b.
     *
     * @return Sequence
     */
    function sorted(callable $comparator = null): Sequence;

    /**
     * Returns the sum of all values in the sequence.
     *
     * @return int|float The sum of all the values in the sequence.
     */
    function sum();

    /**
     * Adds zero or more values to the front of the sequence.
     *
     * @param mixed ...$values
     */
    function unshift(...$values);
}
