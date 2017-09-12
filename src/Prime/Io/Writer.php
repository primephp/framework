<?php

/*
 * The MIT License
 *
 * Copyright 2016 85101346.
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

namespace Prime\Io;

use Prime\Core\Interfaces\IAppendable;
use Prime\Core\TObject;
use Prime\Io\Interfaces\ICloseable;
use Prime\Io\Interfaces\IFlushable;

/**
 * Descrição de Writer <br>
 *
 * @author 85101346
 * @name Writer
 * @package Prime\Io
 * @createAt 25/08/2016
 */
abstract class Writer extends TObject implements IAppendable, ICloseable, IFlushable {

    /**
     * Objeto utilizado para sincronizar as operações no stream
     * @var TObject 
     */
    protected $lock;

    public function __construct(TObject $lock = NULL) {
        $this->data['value'] = '';
        if (!is_null($lock)) {
            $this->lock = $lock;
        }
    }

    /**
     * Adiciona uma sequência de caracteres a este appendable ou uma subsequencia
     * se forem informados os parâmetros $start e $end
     * @param string $char sequência de caracteres a ser adicionada
     * @param int $start Início da subsequência de caracteres a ser adicionada
     * @param int $end Fim da subsequência de caracteres a ser adiconada
     */
    public function append($char, $start = NULL, $end = NULL) {
        $enc = 'UTF-8';
        if (!is_null($start) && !is_null($end)) {
            $size = mb_strlen($char, $enc);
            if ($end > $size || $end < 0 || $start < 0 || $start > $end) {
                throw new \Prime\Core\Exceptions\IndexOutOfBoundsException("$start e $end nao sao valores validos");
            }
            $length = (int)$end - (int)$start + 1;
            $str = mb_substr($char, $start, $length);
        } else {
            $str = $char;
        }
        $this->data['value'] .= $str;
    }

    /**
     * @inheritDoc
     */
    public function close();

    /**
     * @inheritDoc
     */
    abstract public function flush();

    /**
     * @inheritDoc
     */
    abstract public function write($str, $off = NULL, $len = NULL);
}
