<?php

namespace Prime\Collections;

use SplStack;

/**
 * Descrição de Stack
 * @name Stack
 * @package Prime\Collections;
 * @version 1.0
 * @create 03/01/2014
 * @access public
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
class Stack extends SplStack {

    /**
     * A Classe Stack implementa o princípio LIFO (Last In First Out - 
     * Último a Entrar é o Primeiro a Sair)<br/>
     * O construtor aceita um array de valores a serem definidos como elementos
     * Pilha
     * $param array $array
     */
    public function __construct(array $array = NULL) {
        if (!is_null($array)) {
            foreach ($array as $value) {
                $this->push($value);
            }
        }
    }

}
