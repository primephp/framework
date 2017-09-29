<?php

/*
 * The MIT License
 *
 * Copyright 2016 TomSailor.
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

use Prime\Core\Exceptions\IndexOutOfBoundsException;
use Prime\Core\Interfaces\IAppendable;
use Prime\Core\TObject;
use Prime\Io\Interfaces\CloseableInterface;
use Prime\Io\Interfaces\FlushableInterface;

/**
 * Descrição de Writer <br>
 *
 * @author 85101346
 * @name Writer
 * @package Prime\Io
 * @createAt 25/08/2016
 */
abstract class Writer extends TObject implements IAppendable, CloseableInterface, FlushableInterface {

    protected $charset = 'UTF8';

    /**
     * Adiciona uma sequência de caracteres a este appendable ou uma subsequencia
     * se forem informados os parâmetros $start e $end
     * @param string $char sequência de caracteres a ser adicionada
     * @param int $start Início da subsequência de caracteres a ser adicionada
     * @param int $end Fim da subsequência de caracteres a ser adiconada
     */
    public function append($char, $start = NULL, $end = NULL) {
        $enc = $this->charset;
        if (!is_null($start) && !is_null($end)) {
            $size = mb_strlen($char, $enc);
            if ($end > $size || $end < 0 || $start < 0 || $start > $end) {
                throw new IndexOutOfBoundsException("$start e $end nao sao valores validos");
            }
            $length = (int) $end - (int) $start + 1;
            $str = mb_substr($char, $start, $length);
        } else {
            $str = $char;
        }
        $this->data['value'] .= $str;
    }

    /**
     * Escreve uma string
     * @param string $str Uma string
     * @param int $off Posição a partir da qual começará escrever os caracteres
     * @param int $len Número de caracteres a serem escritos
     */
    abstract public function write($str, $off = NULL, $len = NULL);
}
