<?php

namespace Prime\Controller;

/**
 * Descrição da Classe Controller<br>
 * 
 * <br>
 * Por Padrão todos os métodos de Ação do Controller
 * deve ser nomeados com o sufixo Action
 * @package Prime\Controller
 * @author TomSailor
 * @since 03/08/2011
 */
abstract class Controller implements ControllerInterface {

    public function __construct() {
        $this->initialize();
    }

    protected function initialize() {
        
    }

    protected function finalize() {
        
    }

    public function __destruct() {
        $this->finalize();
    }

}
