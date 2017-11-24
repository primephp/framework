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
use IteratorAggregate;
use OutOfBoundsException;
use OutOfRangeException;
use Prime\Core\Exceptions\InvalidParamException;
use Traversable;
use UnderflowException;

/**
 * @name Map
 * @package Prime\DataStructure
 * @since 30/10/2017
 * @author TomSailor
 */
final class Map implements IteratorAggregate, ArrayAccess, Collection
{

    use CollectionTrait;

    /**
     * @var array internal array to store pairs
     */
    private $pairs = [];

    /**
     * Creates a new instance.
     *
     * @param array|Traversable|null $values
     */
    public function __construct($values = null)
    {
        if (func_num_args()) {
            $this->putAll($values);
        }
    }

    /**
     * Atualiza todos os valores, aplicando a função callback para cada valor
     *
     * @param callable $callback Aceita dois argumentos: key e value, será 
     * retornado o valor atualizado.
     */
    public function apply(callable $callback)
    {
        foreach ($this->pairs as &$pair) {
            $pair->value = $callback($pair->key, $pair->value);
        }
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        $this->pairs = [];
    }

    /**
     * Retorna o primeiro par do Mapa
     *
     * @return Pair
     *
     * @throws UnderflowException
     */
    public function first(): Pair
    {
        if ($this->isEmpty()) {
            throw new UnderflowException();
        }
        return $this->pairs[0];
    }

    /**
     * Retorna o último par do Mapa
     * @return Pair
     *
     * @throws UnderflowException
     */
    public function last(): Pair
    {
        if ($this->isEmpty()) {
            throw new UnderflowException();
        }
        return $this->pairs[count($this->pairs) - 1];
    }

    /**
     * Retorna o par em uma posição especificada no Map
     *
     * @param int $position
     *
     * @return Pair
     *
     * @throws OutOfRangeException
     */
    public function skip(int $position): Pair
    {
        if ($position < 0 || $position >= count($this->pairs)) {
            throw new OutOfRangeException();
        }
        return $this->pairs[$position]->copy();
    }

    /**
     * Retorna o resultado da associação de todas as chaves de um determinado
     * objeto Traversable ou um array com seus valores correspondentes, bem como
     * aqueles deste mapa.
     * 
     * @param array|Traversable $values
     *
     * @return Map
     */
    public function merge($values): Map
    {
        $merged = new self($this);
        $merged->putAll($values);
        return $merged;
    }

    /**
     * Cria um novo mapa contendo os pares do instância corrente cujas chaves 
     * também estão presentes no mapa dado. Em outras palavras, retorna uma 
     * cópia do mapa corrente com todas as chaves removidas que não estão no
     * outro mapa.
     *
     * @param Map $map The other map.
     *
     * @return Map Um novo mapa contendo os pares da corrente instância de Map,
     * cujas chaves também estejam presente no mapa dado.
     */
    public function intersect(Map $map): Map
    {
        return $this->filter(function($key) use ($map) {
                    return $map->hasKey($key);
                });
    }

    /**
     * Retorna o resultado da remoção de todas as chaves da instância corrente,
     * que estejam presentes no mapa dado.
     *
     * @param Map $map O mapa que contem as chaves que devem ser excluídas
     *
     * @return Map O resultado da remoção de todas as chaves da instância corrente
     * de Map, que estejam presente no map dado.
     */
    public function diff(Map $map): Map
    {
        return $this->filter(function($key) use ($map) {
                    return !$map->hasKey($key);
                });
    }

    /**
     * Determina se duas chaves são iguais
     *
     * @param mixed $a
     * @param mixed $b
     *
     * @return bool TRUE caso sejam iguais e FALSE caso contrário
     */
    private function keysAreEqual($a, $b): bool
    {
        if (is_object($a) && $a instanceof Hashable) {
            return get_class($a) === get_class($b) && $a->equals($b);
        }
        return $a === $b;
    }

    /**
     * Tenta encontrar uma chave no Mapa
     *
     * @param $key A chave se procurar no Mapa
     *
     * @return Pair|null Retorna o par (Pair) caso a $key seja encontrada ou NULL
     * caso contrário
     */
    private function lookupKey($key)
    {
        foreach ($this->pairs as $pair) {
            if ($this->keysAreEqual($pair->key, $key)) {
                return $pair;
            }
        }
    }

    /**
     * Tenta encontrar um valor no Map.
     *
     * @param $value O valor a ser procurado no mapa
     *
     * @return Pair|null Retorna o par (Pair) caso o $value seja encontrado ou 
     * NULL caso contrário
     */
    private function lookupValue($value)
    {
        foreach ($this->pairs as $pair) {
            if ($pair->value === $value) {
                return $pair;
            }
        }
    }

    /**
     * Retorna se uma associação de determinada chave existe.
     * Verifica se a 
     *
     * @param mixed $key A chave a ser verificada no Mapa
     *
     * @return bool TRUE caso a chave $key exista e FALSE caso contrário
     */
    public function hasKey($key): bool
    {
        return $this->lookupKey($key) !== null;
    }

    /**
     * Retorna se existe uma associação para um determinado valor
     *
     * @param mixed $value O valor a ser verificado no Mapa
     *
     * @return bool TRUE caso o valor exista no Mapa e FALSE caso contrário
     */
    public function hasValue($value): bool
    {
        return $this->lookupValue($value) !== null;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->pairs);
    }

    /**
     * Retorna um novo mapa contendo apenas os valores para os quais um 
     * predicado retorna verdadeiro. Um teste booleano será usado se um 
     * predicado não for fornecido.
     *
     * @param callable|null $callback Aceita um $key e um $value, e retorna:
     *                                true : incluir o valor,
     *                                false: pular o valor.
     *
     * @return Map
     */
    public function filter(callable $callback = null): Map
    {
        $filtered = new self();
        foreach ($this as $key => $value) {
            if ($callback ? $callback($key, $value) : $value) {
                $filtered->put($key, $value);
            }
        }
        return $filtered;
    }

    /**
     * Retorna o valor associado a uma chave ou um padrão opcional se a chave 
     * não estiver associada a um valor.
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed O valor associado ou o padrão de retorno se fornecido.
     *
     * @throws OutOfBoundsException se nenhum padrão foi fornecido e a chave
     *  não está associada a um valor.
     */
    public function get($key, $default = null)
    {
        if (($pair = $this->lookupKey($key))) {
            return $pair->value;
        }
        // Check if a default was provided.
        if (func_num_args() === 1) {
            throw new OutOfBoundsException();
        }
        return $default;
    }

    /**
     * Retorna um conjunto(Set) de todas as chaves do Mapa(Map)
     *
     * @return Set O conjunto contendo todas as chaves do Mapa
     */
    public function keys(): Set
    {
        $key = function($pair) {
            return $pair->key;
        };
        return new Set(array_map($key, $this->pairs));
    }

    /**
     * Retorna um novo Mapa usando os resultados da aplicação da função callback
     * para cada valor
     *
     * As chaves serão iguais em ambos os mapas
     *
     * @param callable $callback Aceita dois argumentos: $key e $value, deverá
     * retornar o valor atualizado
     *
     * @return Map
     */
    public function map(callable $callback): Map
    {
        $apply = function($pair) use ($callback) {
            return $callback($pair->key, $pair->value);
        };
        return new self(array_map($apply, $this->pairs));
    }

    /**
     * Retorna uma sequência(Sequence) de pares(Pair) representando todas as
     * associações
     *
     * @return Sequence
     */
    public function pairs(): Sequence
    {
        $copy = function($pair) {
            return $pair->copy();
        };
        return new Vector(array_map($copy, $this->pairs));
    }

    /**
     * Associa uma chave com um valor, substituindo uma associação anterior se 
     * houver uma.
     *
     * @param mixed $key A chave a ser associada
     * @param mixed $value O valor a ser atribuido
     * @throws InvalidParamException Caso a chave seja uma valor nulo
     */
    public function put($key, $value)
    {
        if (is_null($key)) {
            throw new InvalidParamException('A chave não pode ser null');
        }
        $pair = $this->lookupKey($key);
        if ($pair) {
            $pair->value = $value;
        } else {
            $this->pairs[] = new Pair($key, $value);
        }
    }

    /**
     * Cria uma associação para todas as chaves e seus valores correspondentes
     * de um array ou objeto iterable(Traversable)
     *
     * @param Traversable|array $values
     */
    public function putAll($values)
    {
        foreach ($values as $key => $value) {
            $this->put($key, $value);
        }
    }

    /**
     * Iteratively reduces the map to a single value using a callback.
     *
     * @param callable $callback Accepts the carry, key, and value, and
     *                           returns an updated carry value.
     *
     * @param mixed|null $initial Optional initial carry value.
     *
     * @return mixed The carry value of the final iteration, or the initial
     *               value if the map was empty.
     */
    public function reduce(callable $callback, $initial = null)
    {
        $carry = $initial;
        foreach ($this->pairs as $pair) {
            $carry = $callback($carry, $pair->key, $pair->value);
        }
        return $carry;
    }

    /**
     * Completely removes a pair from the internal array by position. It is
     * important to remove it from the array and not just use 'unset'.
     */
    private function delete(int $position)
    {
        $pair = $this->pairs[$position];
        $value = $pair->value;
        array_splice($this->pairs, $position, 1, null);
        return $value;
    }

    /**
     * Removes a key's association from the map and returns the associated value
     * or a provided default if provided.
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed The associated value or fallback default if provided.
     *
     * @throws OutOfBoundsException if no default was provided and the key is
     *                               not associated with a value.
     */
    public function remove($key, $default = null)
    {
        foreach ($this->pairs as $position => $pair) {
            if ($this->keysAreEqual($pair->key, $key)) {
                return $this->delete($position);
            }
        }
        // Check if a default was provided
        if (func_num_args() === 1) {
            throw new OutOfBoundsException();
        }
        return $default;
    }

    /**
     * Returns a reversed copy of the map.
     *
     * @return Map
     */
    public function reverse()
    {
        $this->pairs = array_reverse($this->pairs);
    }

    /**
     * Returns a reversed copy of the map.
     *
     * @return Map
     */
    public function reversed(): Map
    {
        $reversed = new self();
        $reversed->pairs = array_reverse($this->pairs);
        return $reversed;
    }

    /**
     * Returns a sub-sequence of a given length starting at a specified offset.
     *
     * @param int $offset      If the offset is non-negative, the map will
     *                         start at that offset in the map. If offset is
     *                         negative, the map will start that far from the
     *                         end.
     *
     * @param int|null $length If a length is given and is positive, the
     *                         resulting set will have up to that many pairs in
     *                         it. If the requested length results in an
     *                         overflow, only pairs up to the end of the map
     *                         will be included.
     *
     *                         If a length is given and is negative, the map
     *                         will stop that many pairs from the end.
     *
     *                        If a length is not provided, the resulting map
     *                        will contains all pairs between the offset and
     *                        the end of the map.
     *
     * @return Map
     */
    public function slice(int $offset, int $length = null): Map
    {
        $map = new self();
        if (func_num_args() === 1) {
            $slice = array_slice($this->pairs, $offset);
        } else {
            $slice = array_slice($this->pairs, $offset, $length);
        }
        foreach ($slice as $pair) {
            $map->put($pair->key, $pair->value);
        }
        return $map;
    }

    /**
     * Sorts the map in-place, based on an optional callable comparator.
     *
     * The map will be sorted by value.
     *
     * @param callable|null $comparator Accepts two values to be compared.
     */
    public function sort(callable $comparator = null)
    {
        if ($comparator) {
            usort($this->pairs, function($a, $b) use ($comparator) {
                return $comparator($a->value, $b->value);
            });
        } else {
            usort($this->pairs, function($a, $b) {
                return $a->value <=> $b->value;
            });
        }
    }

    /**
     * Returns a sorted copy of the map, based on an optional callable
     * comparator. The map will be sorted by value.
     *
     * @param callable|null $comparator Accepts two values to be compared.
     *
     * @return Map
     */
    public function sorted(callable $comparator = null): Map
    {
        $copy = $this->copy();
        $copy->sort($comparator);
        return $copy;
    }

    /**
     * Sorts the map in-place, based on an optional callable comparator.
     *
     * The map will be sorted by key.
     *
     * @param callable|null $comparator Accepts two keys to be compared.
     */
    public function ksort(callable $comparator = null)
    {
        if ($comparator) {
            usort($this->pairs, function($a, $b) use ($comparator) {
                return $comparator($a->key, $b->key);
            });
        } else {
            usort($this->pairs, function($a, $b) {
                return $a->key <=> $b->key;
            });
        }
    }

    /**
     * Returns a sorted copy of the map, based on an optional callable
     * comparator. The map will be sorted by key.
     *
     * @param callable|null $comparator Accepts two keys to be compared.
     *
     * @return Map
     */
    public function ksorted(callable $comparator = null): Map
    {
        $copy = $this->copy();
        $copy->ksort($comparator);
        return $copy;
    }

    /**
     * Returns the sum of all values in the map.
     *
     * @return int|float The sum of all the values in the map.
     */
    public function sum()
    {
        return $this->values()->sum();
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $array = [];
        foreach ($this->pairs as $pair) {
            $array[$pair->key] = $pair->value;
        }
        return $array;
    }

    /**
     * Returns a sequence of all the associated values in the Map.
     *
     * @return Sequence
     */
    public function values(): Sequence
    {
        $value = function($pair) {
            return $pair->value;
        };
        return new Vector(array_map($value, $this->pairs));
    }

    /**
     * Creates a new map that contains the pairs of the current instance as well
     * as the pairs of another map.
     *
     * @param Map $map The other map, to combine with the current instance.
     *
     * @return Map A new map containing all the pairs of the current
     *                 instance as well as another map.
     */
    public function union(Map $map): Map
    {
        return $this->merge($map);
        }

        /**
         * Creates a new map using keys of either the current instance or of another
         * map, but not of both.
         *
         * @param Map $map
         *
         * @return Map A new map containing keys in the current instance as well
         *                 as another map, but not in both.
         */
        public function xor(Map $map)
        {
        return $this->merge($map)->filter(function($key) use ($map) {
        return $this->hasKey($key) ^ $map->hasKey($key);
        });
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        foreach ($this->pairs as $pair) {
            yield $pair->key => $pair->value;
        }
    }

    /**
     * Returns a representation to be used for var_dump and print_r.
     */
    public function __debugInfo()
    {
        return $this->pairs()->toArray();
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        if(is_null($offset)){
            $offset = count($this->pairs);
        }
        $this->put($offset, $value);
    }

    /**
     * @inheritdoc
     *
     * @throws OutOfBoundsException
     */
    public function &offsetGet($offset)
    {
        $pair = $this->lookupKey($offset);
        if ($pair) {
            return $pair->value;
        }
        throw new OutOfBoundsException();
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset, null);
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return $this->get($offset, null) !== null;
    }

}
