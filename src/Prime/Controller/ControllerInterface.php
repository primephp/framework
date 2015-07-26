<?php

namespace Prime\Controller;

/**
 * Interface IController
 * @package Prime\Controller 
 * @author TomSailor
 * Define a interface para o tipo Controller
 */
interface ControllerInterface {

    /**
     * DEVEM SER DEFINIDAS AS CONSTANTES COM OS NOMES DAS ACTIONS DEFINIDAS
     * NO CONTROLLER PARA A FACILITAÇÃO DO DESENVOLVIMENTO
     */
    const ACTION_INDEX = 'index';

    public function indexAction();

    /**
     * Método a ser executado quando a inicialização
     * do Controller
     */
    protected function initialize();

    /**
     * Método a ser executado quando da finalização 
     * do Controller
     */
    protected function finalize();
}
