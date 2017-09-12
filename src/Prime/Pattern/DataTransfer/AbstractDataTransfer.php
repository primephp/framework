<?php

/*
 * The MIT License
 *
 * Copyright 2016 Tom Sailor.
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

namespace Prime\Pattern\DataTransfer;

/**
 * Descrição da Classe AbstractDataTransfer<br>
 * Define o esqueleto base para uma série de objetos responsáveis por servirem 
 * como transporte de dados entre os processos, a fim de reduzir o número de 
 * chamadas de método.
 * @name AbstractDataTransfer
 * @package Prime\Pattern\DataTransfer
 * @author Tom Sailor
 * @create 20/09/2016
 */
abstract class AbstractDataTransfer extends \Prime\Core\TObject {

    /**
     * Armazena os dados do objeto
     * @var array
     */
    protected $data = [];
    
    /**
     * Define um valor para a posição passada
     * @param mixed $key
     * @param mixed $value
     */
    public function set($key, $value){
        $this->data[$key] = $value;
    }
    /**
     * Retorna o valor do elemento armazenado na referida posição, caso não existe
     * retorna NULL
     * @param mixed $key
     * @return mixed O valor do item armazenado ou NULL caso ele não exista
     */
    public function get($key){
        if(isset($this->data[$key])){
            return $this->data[$key];
        } else {
            return NULL;
        }
    }

    /**
     * Retorna os dados do objeto no formato JSON
     * @return string
     */
    public function toJson() {
        return json_encode($this->data);
    }

    /**
     * Retorna uma string contendo todo o conteúdo do objeto no formato JSON
     * @return string
     */
    public function toString() {
        return $this->toJson();
    }

    public function toXml() {
        
    }

}
