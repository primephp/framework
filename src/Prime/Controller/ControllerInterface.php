<?php

namespace Prime\Controller;

/**
 * Interface IController
 * @package Prime\Controller 
 * @author TomSailor
 * Define a interface para o tipo Controller
 */
interface ControllerInterface
{

    /**
     * DEVEM SER DEFINIDAS AS CONSTANTES COM OS NOMES DAS ACTIONS DEFINIDAS
     * NO CONTROLLER PARA A FACILITAÇÃO DO DESENVOLVIMENTO
     */
    const ACTION_INDEX = 'index';

    public function dispatch();
}
