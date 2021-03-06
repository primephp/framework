<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Controller;

/**
 * Classe ControllerAction <br>
 * 
 * @name ControllerAction
 * @package Prime\Controller
 * @author Elton Luiz
 * @createAt 02/08/2015
 */
abstract class AbstractControllerAction extends AbstractController
{

    abstract public function index();

    public function __invoke()
    {
        $this->index();
    }

}
