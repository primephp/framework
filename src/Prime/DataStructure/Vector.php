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

use OutOfRangeException;
use Traversable;
use UnexpectedValueException;

/**
 * Um Vector é uma sequência de valores contínuos que cresce e diminui 
 * automaticamente
 * @name Vector
 * @package Prime\DataStructure
 * @since 30/10/2017
 * @author TomSailor
 */
class Vector implements Sequence
{

    /**
     * A capacidade mínima do vetor
     */
    const MIN_CAPACITY = 10;

    /**
     * Armazena a capacidade do Vetor
     * @var int
     */
    private $capacity = self::MIN_CAPACITY;

    /**
     * O conteúdo do vetor
     * @var array
     */
    private $array = [];

    /**
     * A posição do ponteiro no objeto
     * @var int
     */
    private $position = 0;

    /**
     * Cria uma nova instância de Vector, usando um objeto traversable ou um 
     * array
     * @param Traversable|array $values Um objeto Traversable ou um array usado para
     * os valores iniciais do objeto
     */
    public function __construct($values)
    {
        $this->position = 0;
        if (!is_array($values) && !$values instanceof Traversable) {
            throw new UnexpectedValueException(get_called_class() . ' aceita apenas array ou objetos Traversable para sua inicializacao');
        }
        foreach ($values as $value) {
            $this->add($value);
        }
        $this->allocate(self::MIN_CAPACITY);
    }

    /**
     * Adicona o elemento no final do Vetor
     * @param mixed $value
     */
    private function add($value)
    {
        array_push($this->array, $value);
        $this->updateCapacity();
    }

    /**
     * Atualiza a capicidade do Vetor
     */
    private function updateCapacity()
    {
        $this->capacity = $this->count();
    }

    public function allocate(int $capacity)
    {
        $this->array = array_pad($this->array, $capacity, '');
        $this->updateCapacity();
    }

    public function apply(callable $callback)
    {
        array_walk($this->array, $callback);
    }

    public function capacity(): int
    {
        return $this->capacity;
    }

    public function contains(...$values): bool
    {
        foreach ($values as $value) {
            if (!in_array($value, $this->array)) {
                return false;
            }
        }
        return true;
    }

    public function filter(callable $callback): Sequence
    {
        return new Vector(array_filter($this->array, $callback));
    }

    public function find($value)
    {
        return array_search($value, $this->array);
    }

    public function first()
    {
        $this->rewind();
        return $this->current();
    }

    public function get(int $index)
    {
        return $this->offsetGet($index);
    }

    public function insert(int $index, ...$values)
    {
        $i = $index;
        foreach ($values as $value) {
            $this->offsetSet($i, $value);
            $i++;
        }
    }

    public function isEmpty(): bool
    {
        $array = array_filter($this->array);
        if (!empty($array)) {
            return false;
        }
        return true;
    }

    public function join(string $glue = ''): string
    {
        return implode($glue, $this->array);
    }

    public function last()
    {
        return end($this->array);
    }

    public function clear()
    {
        
    }

    public function copy(): Collection
    {
        
    }

    public function toArray(): array
    {
        return $this->array;
    }

    public function count(): int
    {
        return count($this->array);
    }

    public function jsonSerialize()
    {
        return json_encode($this->array);
    }

    /**
     * {@inheritDoc}
     * @param callable $callback
     * @return Sequence
     */
    public function map(callable $callback): Sequence
    {
        return new Vector(array_map($callback, $this->array));
    }

    /**
     * 
     * @param Traversable|array $values
     * @return Sequence
     */
    public function merge($values): Sequence
    {
        $array = array_merge($this->toArray(), $values);
        return new Vector($array);
    }

    public function pop()
    {
        
    }

    public function push(...$values)
    {
        
    }

    public function reduce(callable $callback, int $initial = 0)
    {
        
    }

    public function remove(int $index)
    {
        
    }

    public function reverse()
    {
        
    }

    public function reversed(): Sequence
    {
        
    }

    public function rotate(int $rotations)
    {
        
    }

    public function set(int $index, $value)
    {
        
    }

    public function shift()
    {
        
    }

    public function slice(int $index, int $length = 0): Sequence
    {
        
    }

    public function sort(callable $comparator)
    {
        
    }

    public function sorted(callable $comparator): Sequence
    {
        
    }

    public function sum(): number
    {
        
    }

    public function unshift(...$values)
    {
        
    }

    function rewind()
    {
        $this->position = 0;
    }

    function current()
    {
        return $this->array[$this->position];
    }

    function key()
    {
        return $this->position;
    }

    function next()
    {
        ++$this->position;
    }

    function valid()
    {
        return isset($this->array[$this->position]);
    }

    public function offsetExists($index)
    {
        return isset($this->array[$index]);
    }

    public function offsetGet($index)
    {
        if (isset($this->array[$index])) {
            return $this->array[$index];
        } else {
            throw new OutOfRangeException('Indice para ' . __METHOD__ . ' invalido');
        }
    }

    public function offsetSet($index, $value)
    {
        if(empty($index)){
            $index = $this->capacity();
        }
        if ($index > $this->capacity()) {
            throw new OutOfRangeException('Indice para ' . __METHOD__ . ' invalido');
        }
        $this->array[$index] = $value;
        $this->updateCapacity();
    }

    public function offsetUnset($index)
    {
        unset($this->array[$index]);
    }

}
