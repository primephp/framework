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
     * Inverte a ordem dos elementos da Sequência(Lista).
     */
    function reverse();

    /**
     * Retorna uma cópia da Sequência(Lista) com os elementos em Ordem inversa
     *
     * @return Sequence
     */
    function reversed();

    /**
     * Gira a sequência por um determinado número de rotações, o que equivale a 
     * chamadas sucessivas para 'shift' e 'push' se o número de rotações for 
     * positivo, ou 'pop' e 'unshift' se negativo.
     *
     * @param int $rotations O número de rotações (pode ser negativo).
     */
    function rotate(int $rotations);

    /**
     * Substitui o valor do índice informado na Sequência(Lista) por um novo
     * valor
     *
     * @param int   $index
     * @param mixed $value
     *
     * @throws OutOfRangeException Se o índice não estiver no range [0, size-1]
     */
    function set(int $index, $value);

    /**
     * Remove e retorna o primeiro valor da Sequência(Lista)
     *
     * @return mixed O primeiro elemento da Sequência(Lista)
     *
     * @throws UnderflowException Se a Sequência(Lista) estiver vazia
     */
    function shift();

    /**
     * Retorna uma sub-sequência de um determinado comprimento a partir de um 
     * índice especificado.
     *
     * @param int $index  Se o índice for positivo, a seqüência começará a 
     * partir deste índice na Sequência(Lista). Se o índice for negativo, a 
     * sub-seqüência começará dessa distância do final da sequência.
     *
     * @param int $length Se length for especificado e positivo, então a 
     * sequência terá essa quantidade de elementos. Se a Sequência for menor que 
     * length, então somente os elementos disponíveis serão retornados. Se length 
     * for especificado e negativo então a sequência conterá essa quantidade 
     * elementos a partir do final da Sequência. Se for omitido, então a sequência 
     * terá todos os elementos a partir de $index até o final da Sequência. 
     *
     * @return Sequence
     */
    function slice(int $index, int $length = null): Sequence;

    /**
     * 
     * Ordena a seqüência, com base em uma função callback de comparação.
     *
     * @param callable|null $comparator Aceita dois valores para serem comparados.
     *                                  Deve retorna o resultado de um a <=> b.
     */
    function sort(callable $comparator = null);

    /**
     * Retorna uma copia ordenada da Sequência, baseada numa função callback.
     *
     * @param callable|null $comparator Aceita dois valores para serem comparados.
     *                                  Deve retorna o resultado de um a <=> b.
     *
     * @return Sequence
     */
    function sorted(callable $comparator = null): Sequence;

    /**
     * Retorna a soma de todos os valores da Sequência.
     *
     * @return int|float A soma de todos os valores da Sequência
     */
    function sum();

    /**
     * Adiciona zero ou mais valores no início da Sequência.
     *
     * @param mixed ...$values Aceita como parâmetros a serem adicionados
     */
    function unshift(...$values);
}
