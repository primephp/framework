<?php

namespace Prime\Server\Http;

use Symfony\Component\HttpFoundation\Request as BaseRequest;

/**
 * Descrição da Classe Request
 * Manipula as requisições do usuário
 * @name Request
 * @package Prime\Http
 * @author Elton Luiz
 * @since 12/09/2011
 * @access public
 */
class Request extends BaseRequest
{

    /**
     * Inicializa o objeto de Requisição
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param type $content
     */
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->session = new Session();
    }

    /**
     * Retorna TRUE se for uma requisição ajax
     * @return type
     */
    public function isAjax()
    {
        return parent::isXmlHttpRequest();
    }

    /**
     * Verifica se o token enviado na requisição é válido
     * @param string $token O token a ser verificado
     * @return boolean Retorna true se o token não é null e é válido
     */
    public function checkTokenId($token)
    {
        $session = $this->getSession();
        if (!empty($token) && $session->get('token.id') == $token) {
            return true;
        }
        return false;
    }

}
