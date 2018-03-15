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
use UnderflowException;

/**
 * @name SequenceTrait
 * @package Prime\DataStructure
 * @since 22/11/2017
 * @author TomSailor
 */
trait SequenceTrait 
{

    /**
     * @var array Array interno utilizado para armazenar os valores de Sequence
     */
    private $array = [];

    /**
     * @inheritDoc
     */
    public function __construct($values = null)
    {
        if ($values) {
            $this->pushAll($values);
        }
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return $this->array;
    }

    /**
     * @inheritdoc
     */
    public function apply(callable $callback)
    {
        foreach ($this->array as &$value) {
            $value = $callback($value);
        }
    }

    /**
     * @inheritdoc
     */
    public function merge($values): Sequence
    {
        $copy = $this->copy();
        $copy->pushAll($values);
        return $copy;
    }

    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return count($this->array);
    }

    /**
     * @inheritDoc
     */
    public function contains(...$values): bool
    {
        foreach ($values as $value) {
            if ($this->find($value) === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function filter(callable $callback = null): Sequence
    {
        return new self(array_filter($this->array, $callback ?: 'boolval'));
    }

    /**
     * @inheritDoc
     */
    public function find($value)
    {
        return array_search($value, $this->array, true);
    }

    /**
     * @inheritDoc
     */
    public function first()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException();
        }
        return $this->array[0];
    }

    /**
     * @inheritDoc
     */
    public function get(int $index)
    {
        if (!$this->validIndex($index)) {
            throw new OutOfRangeException();
        }
        return $this->array[$index];
    }

    /**
     * @inheritDoc
     */
    public function insert(int $index, ...$values)
    {
        if (!$this->validIndex($index) && $index !== count($this)) {
            throw new OutOfRangeException();
        }
        array_splice($this->array, $index, 0, $values);
    }

    /**
     * @inheritDoc
     */
    public function join(string $glue = null): string
    {
        return implode($glue, $this->array);
    }

    /**
     * @inheritDoc
     */
    public function last()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException();
        }
        return $this->array[count($this) - 1];
    }

    /**
     * @inheritDoc
     */
    public function map(callable $callback): Sequence
    {
        return new self(array_map($callback, $this->array));
    }

    /**
     * @inheritDoc
     */
    public function pop()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException();
        }
        $value = array_pop($this->array);
        return $value;
    }

    /**
     * Adiciona todos os valores no final do objeto
     * @param \Traversable $values
     */
    private function pushAll($values)
    {
        foreach ($values as $value) {
            $this->array[] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function push(...$values)
    {
        $this->pushAll($values);
    }

    /**
     * @inheritDoc
     */
    public function reduce(callable $callback, $initial = null)
    {
        return array_reduce($this->array, $callback, $initial);
    }

    /**
     * @inheritDoc
     */
    public function remove(int $index)
    {
        if (!$this->validIndex($index)) {
            throw new OutOfRangeException();
        }
        $value = array_splice($this->array, $index, 1, null)[0];
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function reverse()
    {
        $this->array = array_reverse($this->array);
    }

    /**
     * @inheritDoc
     */
    public function reversed(): Sequence
    {
        return new self(array_reverse($this->array));
    }

    /**
     * Converte rotações negativas ou grandes para o mínimo número positivo de 
     * rotações necessárias para rotacionar a sequência para o valor de $r
     * Converts negative or large rotations into the minimum positive number
     * of rotations required to rotate the sequence by a given $r.
     */
    private function normalizeRotations(int $r)
    {
        $n = count($this);
        if ($n < 2)
            return 0;
        if ($r < 0)
            return $n - (abs($r) % $n);
        return $r % $n;
    }

    /**
     * @inheritDoc
     */
    public function rotate(int $rotations)
    {
        for ($r = $this->normalizeRotations($rotations); $r > 0; $r--) {
            array_push($this->array, array_shift($this->array));
        }
    }

    /**
     * @inheritDoc
     */
    public function set(int $index, $value)
    {
        if (!$this->validIndex($index)) {
            throw new OutOfRangeException();
        }
        $this->array[$index] = $value;
    }

    /**
     * @inheritDoc
     */
    public function shift()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException();
        }
        $value = array_shift($this->array);
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function slice(int $offset, int $length = null): Sequence
    {
        if (func_num_args() === 1) {
            $length = count($this);
        }
        return new self(array_slice($this->array, $offset, $length));
    }

    /**
     * @inheritDoc
     */
    public function sort(callable $comparator = null)
    {
        if ($comparator) {
            usort($this->array, $comparator);
        } else {
            sort($this->array);
        }
    }

    /**
     * @inheritDoc
     */
    public function sorted(callable $comparator = null): Sequence
    {
        $copy = $this->copy();
        $copy->sort($comparator);
        return $copy;
    }

    /**
     * @inheritDoc
     */
    public function sum()
    {
        return array_sum($this->array);
    }

    /**
     * @inheritDoc
     */
    public function unshift(...$values)
    {
        if ($values) {
            $this->array = array_merge($values, $this->array);
        }
    }

    /**
     *
     */
    private function validIndex(int $index)
    {
        return $index >= 0 && $index < count($this);
    }

    /**
     * 
     */
    public function getIterator()
    {
        foreach ($this->array as $value) {
            yield $value;
        }
    }

    /**
     * @inheritdoc
     */
    public function clear()
    {
        $this->array = [];
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->push($value);
        } else {
            $this->set($offset, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public function &offsetGet($offset)
    {
        if (!$this->validIndex($offset)) {
            throw new OutOfRangeException();
        }
        return $this->array[$offset];
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        if (is_integer($offset) && $this->validIndex($offset)) {
            $this->remove($offset);
        }
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return is_integer($offset) && $this->validIndex($offset) && $this->get($offset) !== null;
    }

}
