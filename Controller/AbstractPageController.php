<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Controller;

use Prime\Server\Http\Response;
use Symfony\Component\HttpFoundation\Response as SCHR;

/**
 * Classe AbstractPageController <br>
 * Classe unitária para controle de uma ação específica, diferente do Controller
 * onde pode controlar várias ações, sendo o PageController especialista em
 * apenas uma ação
 * @name AbstractPageController
 * @package Prime\Controller
 * @author Elton Luiz
 * 
 * @createAt 02/08/2015
 */
abstract class AbstractPageController extends AbstractController
{

    /**
     * Processa a requisição para a página chamada e retorna uma Response
     * @return Response
     */
    abstract public function handler();

    /**
     * Processa a requisição e retorna uma instância de Response, chamando o 
     * método handler
     * @call AbstractPageController::handler()
     * @return Response
     */
    public function __invoke()
    {
        $handle = $this->handler();
        if (!$handle instanceof SCHR) {
            return new Response($handle);
        }
        return $handle;
    }

}
