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

    /**
     * Armazena a instância de request que será utilizada pelo controller
     * @var Request
     */
    private $request = null;

    /**
     * Armazena a instância de response que será utilizada pelo controller
     * @var Response
     */
    private $response = null;

    public function __construct() {
        $this->initialize();
    }

    protected function initialize() {
        
    }

    public function redirect() {
        
    }

    public function setRequest(Request $request) {
        $this->request = $request;
    }

    /**
     * Retorna o objeto Request 
     * @return Request
     */
    public function getRequest() {
        if (is_null($this->request)) {
            $this->request = Request::createFromGlobals();
        }
        return $this->request;
    }

    /**
     * Retorna o objeto Response
     * @return Response
     */
    public function getResponse() {
        if (is_null($this->response)) {
            $this->response = new Response();
        }
        return $this->response;
    }

    /**
     * Define o Objeto Response que será utilizado pelo Controller
     * @param Response $response
     */
    public function setResponse(Response $response) {
        $this->response = $response;
    }

    public function dispatch() {
        
    }

    protected function beforeDispatch() {
        
    }

    protected function afterDispatch() {
        
    }

    protected function finalize() {
        
    }

    public function __destruct() {
        $this->finalize();
    }

}
