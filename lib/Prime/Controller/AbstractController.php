<?php

namespace Prime\Controller;

use Prime\Server\Http\Request;
use Prime\Server\Http\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Descrição da Classe AbstractController<br>
 * 
 * <br>
 * Por Padrão todos os métodos de Ação do Controller
 * deve ser nomeados com o sufixo Action
 * @name AbstractController
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
        $this->request = $this->getRequest();
        $this->response = $this->getResponse();
    }

    /**
     * Redireciona para uma URL passada como parâmetro
     * @param string $url A Url para qual a requisição deve ser redirecionada
     * @param int $status O status HTTP, por padrão é 302
     * @return RedirectResponse retorna uma instância da classe RedirectResponse
     */
    public function redirect($url, $status = 301) {
        return new RedirectResponse($url, $status);
    }

    /**
     * Define a requisição a ser utilizada pelo controller
     * @param Request $request
     */
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

    /**
     * Executa as ações antes da finalização do objeto 
     */
    protected function finalize() {
        
    }

    public function __destruct() {
        $this->finalize();
    }

}
