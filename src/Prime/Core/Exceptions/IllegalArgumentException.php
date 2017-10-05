<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Core\Exceptions;

/**
 * Descrição de IllegalArgumentException
 * Lançada para indicar que um método tem sido passado um argumento ilegal ou 
 * impróprio.
 * @author Elton Luiz
 * @createAt 15/08/2016
 */
class IllegalArgumentException extends \RuntimeException
{

    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
