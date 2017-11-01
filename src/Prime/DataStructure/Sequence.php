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
interface Sequence extends Collection
{

    /**
     * Aloca memória suficiente para uma capacidade requerida.
     * @param int $capacity
     */
    public function allocate(int $capacity);

    /**
     * Atualiza todos os valores aplicando uma função de retorno de chamada para cada valor.
     * @param callable $callback
     */
    public function apply(callable $callback);

    /**
     * Retorna a capacidade atual
     */
    public function capacity(): int;

    /**
     * Verifica se o objeto contem os valores passados
     * @param mixed $values Valores passados
     */
    public function contains(...$values): bool;

    /**
     * Cria uma nova sequência usando um callable para determinar quais valores
     * incluir
     * @param callable $callback
     */
    public function filter(callable $callback): Sequence;

    /**
     * Atualiza todos os valores aplicando uma função de retorno de chamada 
     * para cada valor.
     * @param mixed $value
     */
    public function find($value);

    /**
     * Retorna o primeiro valor da sequência
     * @return mixed O primeiro valor da sequência
     */
    public function first();

    /**
     * Retorna o valor de um determinado índice
     * @param int $index O índice para acessar, começando de 0
     */
    public function get(int $index);

    /**
     * Insere valores na sequência em um determinado índice.
     * @param int $index O índice para inserir. 0 <= index <= count
     * @param mixed $values
     */
    public function insert(int $index, ...$values);

    /**
     * Junta todos os valores como uma string usando um separador opcional entre 
     * cada valor
     * 
     * @param string $glue Uma string opcional para separar cada valor
     */
    public function join(string $glue = ''): string;

    /**
     * Retorna o último valor da sequência
     * @return mixed O último valor da sequência
     */
    public function last();

    /**
     * Retorna o resultado a aplicação da função $callback para cada valor da
     * sequência
     * @param callable $callback
     */
    public function map(callable $callback): Sequence;

    /**
     * Retorna o resultado da adição de todos os valores dados 
     * @param type $values Um objeto traversable ou um array
     */
    public function merge($values): Sequence;

    /**
     * Remove e retorna o último valor
     * @return mixed O último valor removido
     */
    public function pop();

    /**
     * Adiciona valores no final do objeto
     * @param mixed $values Os valores a serem adicionados
     */
    public function push(...$values);

    /**
     * Reduz a sequência para um único valor usando uma função $callback.
     * @param callable $callback
     * @param int $initial
     */
    public function reduce(callable $callback, int $initial = 0);

    /**
     * Remove e retorna o valor do índice informado
     * @param int $index O índice do valor a ser removeido
     * @throws \OutOfRangeException Se o índice não é válido
     */
    public function remove(int $index);

    /**
     * Inverte a sequenca do conteúdo do objeto
     */
    public function reverse();

    /**
     * Retorna uma cópia com conteúdo em ordem inversa
     * @return Sequence Uma cópia inversa do objeto
     */
    public function reversed(): Sequence;

    /**
     * Rotociona a sequência um determinado número de vezes, removendo o primeiro
     * elemento e colocando-o no final da sequência
     * @param int $rotations Número de vezes que a sequência deverá ser 
     * rotacionada
     */
    public function rotate(int $rotations);

    /**
     * Atualiza o valor de um determinado índice
     * @param int $index O índice do valor a ser atualizado
     * @param mixed $value O novo valor
     * @throws \OutOfRangeException Se o índice não for válido
     */
    public function set(int $index, $value);

    /**
     * Remove e retorna o primeiro valor da sequência
     * @return mixed O primeiro valor, que foi removido
     */
    public function shift();

    /**
     * Retorna uma sub-sequência de um determinado intervalo
     * @param int $index O índice no qual a sub-sequência começa
     * @param int $length Se um comprimento é dado e é positivo, a sequência 
     * resultante terá muitos valores nela. Se o comprimento resultar em um 
     * transbordamento, somente os valores até o final da seqüência serão 
     * incluídos. Se um comprimento é dado e é negativo, a seqüência irá parar 
     * que muitos valores do final. Se um comprimento não for fornecido, a 
     * seqüência resultante conterá todos os valores entre o índice e o fim 
     * da seqüência.
     * @return Sequence Uma sub-sequência do intervalo dado
     */
    public function slice(int $index, int $length = 0): Sequence;

    /**
     * Ordena o conteúdo do objeto
     * @param callable $comparator
     */
    public function sort(callable $comparator);

    /**
     * Retorna uma cópia do objeto com os elementos ordenados
     * @param callable $comparator
     * @return Sequence Retorna uma cópia ordenada do conteúdo da Sequência
     */
    public function sorted(callable $comparator): Sequence;

    /**
     * Retorna uma soma de todos os elementos da sequência. Arrays e objetos são 
     * considerados iguais a zero ao calcular a soma.
     * @return number A soma de todos os elementos da sequência 
     */
    public function sum();

    /**
     * Adiciona valores no início da sequência
     * @param mixed $values
     */
    public function unshift(...$values);
}
