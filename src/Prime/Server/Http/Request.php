<?php

namespace Prime\Server\Http;

use Symfony\Component\HttpFoundation\Request as BaseRequest;

/**
 * Descrição da Classe Request
 * Manipula as requisições do usuário
 * @name Request
 * @package Prime\Http
 * @author TomSailor
 * @since 12/09/2011
 * @access public
 */
class Request extends BaseRequest
{

    /**
     * Retorna TRUE se for uma requisição ajax
     * @return type
     */
    public function isAjax()
    {
        return parent::isXmlHttpRequest();
    }

}
