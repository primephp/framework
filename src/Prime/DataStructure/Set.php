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

use ArrayAccess;
use Error;
use IteratorAggregate;
use OutOfBoundsException;
use OutOfRangeException;
use Traversable;

/**
 * @name Set
 * @package Prime\DataStructure
 * @since 30/10/2017
 * @author TomSailor
 * Um Set (Conjunto) é uma sequência de valores únicos. Esta implementação usa a 
 * mesma tabela hash de Map, onde os valores são usados como chaves e o valor 
 * mapeado é ignorado
 */
class Set implements IteratorAggregate, ArrayAccess, Collection {

    use CollectionTrait;

    /**
     * @var Map internal map to store the values.
     */
    private $table;

    /**
     * Cria um novo Conjunto(Set) usando os valores de um array ou de um objeto 
     * Traversable. As chaves de 
     * Creates a new set using the values of an array or Traversable object.
     * As chaves não serão preservadas
     *
     * @param array|Traversable|null $values
     */
    public function __construct($values = null) {
        $this->table = new Map();
        if (func_num_args()) {
            $this->add(...$values);
        }
    }

    /**
     * Adiciona zero ou mais valores no conjunto(Set)
     *
     * @param mixed ...$values
     */
    public function add(...$values) {
        foreach ($values as $value) {
            $this->table->put($value, null);
        }
    }

    /**
     * Remove todos os valores do Conjunto(Set)
     */
    public function clear() {
        $this->table->clear();
    }

    /**
     * Verifica se o conjunto(Set) contém todos de zero ou mais valores
     *
     * @param mixed ...$values
     *
     * @return bool true se pelo menos um valor foi fornecido e o conjunto 
     * contém todos os valores dados, falso caso contrário.
     */
    public function contains(...$values): bool {
        foreach ($values as $value) {
            if (!$this->table->hasKey($value)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Retorna uma cópia do conjunto(Set)
     * @return \Prime\DataStructure\Collection
     */
    public function copy(): Collection {
        return new self($this);
    }

    /**
     * Retorna o número de elementos do conjunto(Set)
     * @return int
     */
    public function count(): int {
        return count($this->table);
    }

    /**
     * Cria um novo conjunto(Set) usando valores deste conjunto que não esteja 
     * no outro conjunto(Set)
     *
     * Formally: A \ B = {x ∈ A | x ∉ B}
     *
     * @param Set $set
     *
     * @return Set
     */
    public function diff(Set $set): Set {
        return $this->table->diff($set->table)->keys();
    }

    /**
     * Cria um novo conjunto usando valores em este conjunto ou em outro 
     * conjunto, mas não em ambos.
     *
     * Formally: A ⊖ B = {x : x ∈ (A \ B) ∪ (B \ A)}
     *
     * @param Set $set
     *
     * @return Set
     */
    public function xorAnother(Set $set): Set {
        return $this->table->xor($set->table)->keys();
    }

    /**
     * Retorna um novo conjunto contendo apenas os valores para os quais  
     * a função $callback retorna TRUE. Um teste booleano será usado se uma
     * função $callback não for fornecida.
     *
     * @param callable|null $callback Aceita um valor e retorna um boleano:
     *                                 true : incluir o valor,
     *                                 false: pular o valor.
     *
     * @return Set
     */
    public function filter(callable $callback = null): Set {
        return new self(array_filter($this->toArray(), $callback ?: 'boolval'));
    }

    /**
     * Retorna o primeiro valor do conjunto(Set)
     *
     * @return mixed O primeiro valor do conjunto(Set)
     */
    public function first() {
        return $this->table->first()->key;
    }

    /**
     * Retorna o valor de uma posíção específica no conjunto(Set)
     *
     * @param int $position
     *
     * @return mixed|null
     *
     * @throws OutOfRangeException
     */
    public function get(int $position) {
        return $this->table->skip($position)->key;
    }

    /**
     * Cria um novo conjunto(Set) usando a interseção dos valores do conjunto(Set)
     * passado com a instância atual
     *
     * Em outras palavras, retorna uma cópia deste conjunto com todos os valores 
     * removidos que não estão no outro conjunto.
     *
     * Formally: A ∩ B = {x : x ∈ A ∧ x ∈ B}
     *
     * @param Set $set
     *
     * @return Set
     */
    public function intersect(Set $set): Set {
        return $this->table->intersect($set->table)->keys();
    }

    /**
     * Verifica se o conjunto(Set) está vazio
     * @return bool TRUE caso não tenha elementos no conjunto e <br>FALSE caso contrário
     */
    public function isEmpty(): bool {
        return $this->table->isEmpty();
    }

    /**
     * Joins all values of the set into a string, adding an optional 'glue'
     * between them. Returns an empty string if the set is empty.
     *
     * @param string $glue
     *
     * @return string
     */
    public function join(string $glue = null): string {
        return implode($glue, $this->toArray());
    }

    /**
     * Returns the last value in the set.
     *
     * @return mixed the last value in the set.
     */
    public function last() {
        return $this->table->last()->key;
    }

    /**
     * Iteratively reduces the set to a single value using a callback.
     *
     * @param callable $callback Accepts the carry and current value, and
     *                           returns an updated carry value.
     *
     * @param mixed|null $initial Optional initial carry value.
     *
     * @return mixed The carry value of the final iteration, or the initial
     *               value if the set was empty.
     */
    public function reduce(callable $callback, $initial = null) {
        $carry = $initial;
        foreach ($this as $value) {
            $carry = $callback($carry, $value);
        }
        return $carry;
    }

    /**
     * Remove zero ou mais valores do conjunto(Set)
     *
     * @param mixed ...$values
     */
    public function remove(...$values) {
        foreach ($values as $value) {
            $this->table->remove($value, null);
        }
    }

    /**
     * Inverte os elementos do conjunto(Set)
     */
    public function reverse() {
        $this->table->reverse();
    }

    /**
     * Returns a reversed copy of the set.
     *
     * @return Set
     */
    public function reversed(): Set {
        $reversed = $this->copy();
        $reversed->table->reverse();
        return $reversed;
    }

    /**
     * Returns a subset of a given length starting at a specified offset.
     *
     * @param int $offset If the offset is non-negative, the set will start
     *                    at that offset in the set. If offset is negative,
     *                    the set will start that far from the end.
     *
     * @param int $length If a length is given and is positive, the resulting
     *                    set will have up to that many values in it.
     *                    If the requested length results in an overflow, only
     *                    values up to the end of the set will be included.
     *
     *                    If a length is given and is negative, the set
     *                    will stop that many values from the end.
     *
     *                    If a length is not provided, the resulting set
     *                    will contains all values between the offset and the
     *                    end of the set.
     *
     * @return Set
     */
    public function slice(int $offset, int $length = null): Set {
        $sliced = new self();
        $sliced->table = $this->table->slice($offset, $length);
        return $sliced;
    }

    /**
     * Sorts the set in-place, based on an optional callable comparator.
     *
     * @param callable|null $comparator Accepts two values to be compared.
     *                                  Should return the result of a <=> b.
     */
    public function sort(callable $comparator = null) {
        $this->table->ksort($comparator);
    }

    /**
     * Returns a sorted copy of the set, based on an optional callable
     * comparator. Natural ordering will be used if a comparator is not given.
     *
     * @param callable|null $comparator Accepts two values to be compared.
     *                                  Should return the result of a <=> b.
     *
     * @return Set
     */
    public function sorted(callable $comparator = null): Set {
        $sorted = $this->copy();
        $sorted->table->ksort($comparator);
        return $sorted;
    }

    /**
     * Returns the result of adding all given values to the set.
     *
     * @param array|Traversable $values
     *
     * @return \Ds\Set
     */
    public function merge($values): Set {
        $merged = $this->copy();
        foreach ($values as $value) {
            $merged->add($value);
        }
        return $merged;
    }

    /**
     * Retorna os elementos do conjunto(Set) como um array
     * @return array Um array contendo os elementos do conjunto
     */
    public function toArray(): array {
        return iterator_to_array($this);
    }

    /**
     * Retorna a soma de todos os valores do conjunto(Set)
     *
     * @return int|float A soma de todos os valores do conjunto(Set)
     */
    public function sum() {
        return array_sum($this->toArray());
    }

    /**
     * Cria um novo conjunto que contanha os valores deste conjunto(Set), assim como
     * os valores de outro conjunto(Set)
     *
     * Formally: A ∪ B = {x: x ∈ A ∨ x ∈ B}
     *
     * @param Set $set
     *
     * @return Set
     */
    public function union(Set $set): Set {
        $union = new self();
        foreach ($this as $value) {
            $union->add($value);
        }
        foreach ($set as $value) {
            $union->add($value);
        }
        return $union;
    }

    /**
     * Retorna iterador
     */
    public function getIterator() {
        foreach ($this->table as $key => $value) {
            yield $key;
        }
    }

    /**
     * @inheritdoc
     *
     * @throws OutOfBoundsException
     */
    public function offsetSet($offset, $value) {
        if ($offset === null) {
            $this->add($value);
            return;
        }
        throw new OutOfBoundsException();
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset) {
        return $this->table->skip($offset)->key;
    }

    /**
     * @inheritdoc
     *
     * @throws Error
     */
    public function offsetExists($offset) {
        throw new Error();
    }

    /**
     * @inheritdoc
     *
     * @throws Error
     */
    public function offsetUnset($offset) {
        throw new Error();
    }

}