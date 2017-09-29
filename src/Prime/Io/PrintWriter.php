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

namespace Prime\Io;

use Prime\Core\TString;
use Prime\Io\Excepction\IOException;

/**
 * Description of PrintWriter
 *
 * @author quantum
 */
class PrintWriter extends Writer {

    /**
     *
     * @var Writer;
     */
    protected $out;

    /**
     *
     * @var boolean
     */
    private $autoFlush;

    /**
     *
     * @var boolean
     */
    private $trouble = false;

    /**
     *
     * @var Formater
     */
    private $formatter;

    /**
     *
     * @var PrintStream
     */
    private $psOut = null;

    /**
     *
     * @var string
     */
    private $lineSeparator;

    /**
     * 
     * @param \Prime\Io\Writer $out
     * @param boolean $autoFlush
     */
    public function __construct(Writer $out = NULL, $autoFlush = false) {
        parent::__construct($out);
        $this->out = $out;
        $this->autoFlush = $autoFlush;
        $this->lineSeparator = '\n';
    }
    /**
     * Adiciona uma sequência de caracteres a este appendable ou uma subsequencia
     * se forem informados os parâmetros $start e $end
     * @param string $char sequência de caracteres a ser adicionada
     * @param int $start Início da subsequência de caracteres a ser adicionada
     * @param int $end Fim da subsequência de caracteres a ser adiconada
     * @return $this
     */
    public function append($char, $start = NULL, $end = NULL) {
        parent::append($char, $start, $end);
        return $this;
    }

    /**
     * Verifica se o fluxo não foi fechado
     * @throws IOException Lança uma exceção se o fluxo foi fechado
     */
    private function ensureOpen() {
        if ($this->out == null) {
            throw new IOException('Stream fechado');
        }
    }
    
    private function newLine(){
        try {
            
        } catch (IOException $exc) {
            echo $exc->getTraceAsString();
        }
        }

    /**
     * {@inheritDoc}
     */
    public function write($str, $off = 0, $len = NULL) {
        try {
            if (!is_object($str)) {
                $str = new TString($str);
            }
            if (is_null($len)) {
                $len = $str->length();
            }
            $this->out->write($str->toString(), $off, $len);
        } catch (IOException $x) {
            $this->trouble = true;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function flush() {
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function close() {
        ;
    }

    /**
     * Define que um erro ocorreu
     */
    protected function setError() {
        $this->trouble = true;
    }
    
    public function printOut(){
        
    }
    
    public function printf(){
        printf($format, $args);
    }
    
    public function println(){
        
    }

}
