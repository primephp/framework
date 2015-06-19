<?php

namespace Prime\Collections;

use SplQueue;

/**
 * Descrição de Queue
 * @name Queue
 * @package Prime\Collections;
 * @version 1.0
 * @create 03/01/2014
 * @access public
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
class Queue extends SplQueue {

    /**
     * A classe Queue implementa o princípio FIFO (First In First Out = 
     * Primeiro a Entrar é o Primeiro a Sair).<br/>
     * O construtor aceita um array de valores a serem definidos como elementos
     * Fila
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
