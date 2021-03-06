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
final class Map implements IteratorAggregate, ArrayAccess, Collection {

    use CollectionTrait;

    /**
     * @var array Array Interno para armazenamento dos pares(Pair)
     */
    private $pairs = [];

    /**
     * Creates a new instance.
     *
     * @param array|Traversable|null $values
     */
    public function __construct($values = null) {
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
    public function apply(callable $callback) {
        foreach ($this->pairs as &$pair) {
            $pair->value = $callback($pair->key, $pair->value);
        }
    }

    /**
     * @inheritDoc
     */
    public function clear() {
        $this->pairs = [];
    }

    /**
     * Retorna o primeiro par do Mapa
     *
     * @return Pair
     *
     * @throws UnderflowException
     */
    public function first(): Pair {
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
    public function last(): Pair {
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
    public function skip(int $position): Pair {
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
    public function merge($values): Map {
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
    public function intersect(Map $map): Map {
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
    public function diff(Map $map): Map {
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
    private function keysAreEqual($a, $b): bool {
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
    private function lookupKey($key) {
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
    private function lookupValue($value) {
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
    public function hasKey($key): bool {
        return $this->lookupKey($key) !== null;
    }

    /**
     * Retorna se existe uma associação para um determinado valor
     *
     * @param mixed $value O valor a ser verificado no Mapa
     *
     * @return bool TRUE caso o valor exista no Mapa e FALSE caso contrário
     */
    public function hasValue($value): bool {
        return $this->lookupValue($value) !== null;
    }

    /**
     * @inheritDoc
     */
    public function count(): int {
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
    public function filter(callable $callback = null): Map {
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
    public function get($key, $default = null) {
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
    public function keys(): Set {
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
    public function map(callable $callback): Map {
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
    public function pairs(): Sequence {
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
    public function put($key, $value) {
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
    public function putAll($values) {
        foreach ($values as $key => $value) {
            $this->put($key, $value);
        }
    }

    /**
     * Iterativamente reduz o mapa de forma para um único valor usando uma função
     * callback
     *
     * @param callable $callback Aceita $carry, $key e $value, e retorna o valor
     * $carry atualizado
     *
     * @param mixed|null $initial Valor inicial opctional para o $carry
     *
     * @return mixed O valor de transporte da iteração final, ou o valor 
     * inicial se o mapa estiver vazio.
     */
    public function reduce(callable $callback, $initial = null) {
        $carry = $initial;
        foreach ($this->pairs as $pair) {
            $carry = $callback($carry, $pair->key, $pair->value);
        }
        return $carry;
    }

    /**
     * Remove um par de uma dada posição.
     * @param int $position A posição a qual deve ser removido o par(Pair)
     * @return mixed O valor do par da posição passada
     */
    private function delete(int $position) {
        $pair = $this->pairs[$position];
        $value = $pair->value;
        array_splice($this->pairs, $position, 1, null);
        return $value;
    }

    /**
     * Remove a associação de uma chave $key do mapa e retorna o valor associado
     * ou um padrão fornecido, se fornecido.
     *
     * @param mixed $key A chave a ser verificada
     * @param mixed $default O valor padrão de retorno, opcional
     *
     * @return mixed O valor associado ou o padrão de retorno se fornecido
     *
     * @throws OutOfBoundsException Se nenhum valor padrão foi fornecido e a chave
     * informada não for associada a nenhum valor do mapa.
     */
    public function remove($key, $default = null) {
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
     * Inverta a ordem dos elementos do Mapa
     */
    public function reverse() {
        $this->pairs = array_reverse($this->pairs);
    }

    /**
     * Retorna um Mapa contendo o elemento da instância atual em ordem inversa
     *
     * @return Map Uma nova instância de Mapa(Map) contendo os elementos do Mapa atual, porém em ordem
     * inversa
     */
    public function reversed(): Map {
        $reversed = new self();
        $reversed->pairs = array_reverse($this->pairs);
        return $reversed;
    }

    /**
     * Retorna uma sub-sequência de um determinado comprimento a partir de um 
     * ponto especificado.
     *
     * @param int $offset Se o deslocamento não for negativo, o mapa começará 
     * a partir deste ponto no mapa. Se o deslocamento for negativo, o mapa 
     * começará tão longe do final.
     *
     * @param int|null $length Se o comprimento é dado e é positivo, a sequência
     *  terá muitos elementos nela. Se a matriz for menor do que o comprimento,
     *  somente os elementos de matriz disponíveis estarão presentes. Se o 
     * comprimento é dado e é negativo, a seqüência irá parar que muitos 
     * elementos do final da matriz. Se for omitido, a seqüência terá tudo de 
     * compensação até o final da matriz
     *
     * @return Map
     */
    public function slice(int $offset, int $length = null): Map {
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
     * Ordena o mapa, com base em um funcão de comparação opcional
     *
     * O Mapa será ordenado por valor
     *
     * @param callable|null $comparator Aceita dois valores a serem comparados
     */
    public function sort(callable $comparator = null) {
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
     * Retorna um cópia ordenada do mapa, baseado uma função optional de comparação.
     * O mapa será ordenado por valor.
     *
     * @param callable|null $comparator Aceita dois valores a serem comparados
     *
     * @return Map
     */
    public function sorted(callable $comparator = null): Map {
        $copy = $this->copy();
        $copy->sort($comparator);
        return $copy;
    }

    /**
     * Ordena o mapa, baseado em um <i>callable</i> optional de comparação.
     *
     * O mapa será ordenado pelas chaves ($key)
     *
     * @param callable|null $comparator Aceita dois valores a serem comparados
     */
    public function ksort(callable $comparator = null) {
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
     * Retorna uma cópia do mapa, baseado em um callable opcional de comparação.
     * O mapa será ordenado pelas chaves $key
     *
     * @param callable|null $comparator Aceita dois valores a serem comparados
     *
     * @return Map
     */
    public function ksorted(callable $comparator = null): Map {
        $copy = $this->copy();
        $copy->ksort($comparator);
        return $copy;
    }

    /**
     * Retorna a soma de todos os valores do mapa.
     *
     * @return int|float A soma de todos os valores do mapa
     */
    public function sum() {
        return $this->values()->sum();
    }
    
    /**
     * Retorna os valores do Mapa(Map) no formato de um array
     * @return array
     */
    public function toArray(): array {
        $array = [];
        foreach ($this->pairs as $pair) {
            $array[$pair->key] = $pair->value;
        }
        return $array;
    }

    /**
     * Retorna uma sequência(Lista) de todos os valores associados no Mapa
     *
     * @return Sequence
     */
    public function values(): Sequence {
        $value = function($pair) {
            return $pair->value;
        };
        return new Vector(array_map($value, $this->pairs));
    }

    /**
     * Cria um novo mapa que contém os pares da instância atual, bem como os 
     * pares de outro mapa.
     *
     * @param Map $map O outro mapa, para ser combinado com o atual instância
     *
     * @return Map Uma nova instância de Mapa, contendo todos os pares da instância atual
     * assim como a do outro mapa
     */
    public function union(Map $map): Map {
        return $this->merge($map);
    }

    /**
     * Cria um novo mapa usando as chaves $keys do mapa corrente ou de outro mapa, 
     * mas não de ambos
     *
     * @param Map $map
     *
     * @return Map O novo mapa contendo as chaves do mapa da instância corrente
     * ou de outro mapa, mas não contido em ambos.
     */
    public function xorAnother(Map $map) {
        return $this->merge($map)->filter(function($key) use ($map) {
                    return $this->hasKey($key) ^ $map->hasKey($key);
                });
    }

    /**
     * @inheritDoc
     */
    public function getIterator() {
        foreach ($this->pairs as $pair) {
            yield $pair->key => $pair->value;
        }
    }

    /**
     * Retorna uma representação para ser usada por var_dump e print_r
     * 
     * @return array
     */
    public function __debugInfo() {
        return $this->pairs()->toArray();
    }

    /**
     * Atribui um valor a uma posição específica
     * @param mixed $offset A posição na qual se deseja atribuir um valor.
     * @param mixed $value O valor a ser atribuído
     */
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $offset = count($this->pairs);
        }
        $this->put($offset, $value);
    }

    /**
     * Retorna o valor de uma posição específica. 
     * @param mixed $offset A posição a ser obtida
     * @return mixed O valor do Pair da posição especificada
     * @throws OutOfBoundsException
     */
    public function &offsetGet($offset) {
        $pair = $this->lookupKey($offset);
        if ($pair) {
            return $pair->value;
        }
        throw new OutOfBoundsException();
    }

    /**
     * Remove uma posição
     * @param mixed $offset A posição a ser removida
     */
    public function offsetUnset($offset) {
        $this->remove($offset, null);
    }

    /**
     * Verifica se existe uma chave no Mapa
     * @param mixed $offset A chave a ser verificada no mapa
     * @return bool Retorna TRUE caso a chave exista ou FALSE caso contrário
     */
    public function offsetExists($offset) {
        return $this->get($offset, null) !== null;
    }

}
