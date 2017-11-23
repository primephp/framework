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
use Traversable;
use UnderflowException;

/**
 * @name Stack
 * @package Prime\DataStructure
 * @since 30/10/2017
 * @author TomSailor
 */
final class Stack implements IteratorAggregate, ArrayAccess, Collection
{
    use CollectionTrait;
    /**
     * @var Vector internal vector to store values of the stack.
     */
    private $vector;
    /**
     * Creates an instance using the values of an array or Traversable object.
     *
     * @param array|Traversable $values
     */
    public function __construct($values = null)
    {
        $this->vector = new Vector($values ?: []);
    }
    /**
     * Clear all elements in the Stack
     */
    public function clear()
    {
        $this->vector->clear();
    }
    /**
     * @inheritdoc
     */
    public function copy(): Collection
    {
        return new self($this->vector);
    }
    /**
     * Returns the number of elements in the Stack
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->vector);
    }
    /**
     * Returns the value at the top of the stack without removing it.
     *
     * @return mixed
     *
     * @throws UnderflowException if the stack is empty.
     */
    public function peek()
    {
        return $this->vector->last();
    }
    /**
     * Returns and removes the value at the top of the stack.
     *
     * @return mixed
     *
     * @throws UnderflowException if the stack is empty.
     */
    public function pop()
    {
        return $this->vector->pop();
    }
    /**
     * Pushes zero or more values onto the top of the stack.
     *
     * @param mixed ...$values
     */
    public function push(...$values)
    {
        $this->vector->push(...$values);
    }
    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_reverse($this->vector->toArray());
    }
    /**
     *
     */
    public function getIterator()
    {
        while ( ! $this->isEmpty()) {
            yield $this->pop();
        }
    }
    /**
     * @inheritdoc
     *
     * @throws OutOfBoundsException
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->push($value);
        } else {
            throw new OutOfBoundsException();
        }
    }
    /**
     * @inheritdoc
     *
     * @throws Error
     */
    public function offsetGet($offset)
    {
        throw new Error();
    }
    /**
     * @inheritdoc
     *
     * @throws Error
     */
    public function offsetUnset($offset)
    {
        throw new Error();
    }
    /**
     * @inheritdoc
     *
     * @throws Error
     */
    public function offsetExists($offset)
    {
        throw new Error();
    }
}