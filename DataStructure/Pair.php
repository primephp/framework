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

/**
 * @name Pair
 * @package Prime\DataStructure
 * @since 30/10/2017
 * @author TomSailor
 * Um Pair(par) representa uma chave e um valor associado
 */
class Pair implements \JsonSerializable
{

    /**
     * @param mixed $key A chave do par
     */
    public $key;

    /**
     * @param mixed $value O valor do par
     */
    public $value;

    /**
     * Creates a new instance.
     *
     * @param mixed $key
     * @param mixed $value
     */

    /**
     * Cria uma nova instância
     * @param mixed $key A chave para o Pair
     * @param mixed $value O valor para ser associado a respectiva chave
     */
    public function __construct($key = null, $value = null)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Isso permite que unset ($ pair-> key) não remova completamente a propriedade, mas seja definido como nulo em vez disso.
     * @param mixed $name
     * @return mixed|null
     * @throws OutOfBoundsException
     */
    public function __get($name)
    {
        if ($name === 'key' || $name === 'value') {
            $this->$name = null;
            return;
        }
        throw new OutOfBoundsException();
    }

    /**
     * Retorna a copia do Pair(par)
     *
     * @return Pair
     */
    public function copy(): Pair
    {
        return new self($this->key, $this->value);
    }

    /**
     * Retorna uma representação a ser usada para var_dump e print_r.
     *
     * @return array
     */
    public function __debugInfo()
    {
        return $this->toArray();
    }

    /**
     * Converte o Pair(par) para um array
     * @return array Um array contendo todos a chave e o valor do Pair(par)
     */
    public function toArray(): array
    {
        return ['key' => $this->key, 'value' => $this->value];
    }

    /**
     * Retorna uma representação que pode ser convertida em JSON.
     * @return array Um array contendo todos a chave e o valor do Pair(par)
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Retorna uma representação de string do par.
     * @return string
     */
    public function __toString()
    {
        return 'object(' . get_class($this) . ')';
    }

}
