<?php

namespace Prime\Controller;

use Prime\Server\Http\Request;
use Prime\Server\Http\Response;

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
abstract class AbstractController implements ControllerInterface {

    public function redirect() {
        
    }

    public function setRequest(Request $request) {
        
    }

    public function getRequest() {
        
    }

    public function getResponse() {
        
    }
    
    public function setResponse(Response $response){
        
    }

    public function dispatch() {
        
    }

    public function onDispatch() {
        
    }

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
