<?php

/*
 * Arquivo de configuração de rotas para o módulo
 */

use Prime\Server\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->setGet('/', 'App\Modules\Index\Controller\IndexController@index');

return $routes;

