<?php

use Prime\Server\Http\Response;
use Prime\Server\Routing\RouteCollection;

/*
  |-------------------------------------------------------------------------
  | RouteCollection
  |-------------------------------------------------------------------------
  |
  | Objeto no qual serão definidas as rotas utilizadas na aplicação
  |
 */
$routes = new RouteCollection();

/*
  |-------------------------------------------------------------------------
  | Rota para o método GET
  |-------------------------------------------------------------------------
  |
  | Define o local aonde serão armazenados os templates que serão utilizados na aplicação
  |
 */
$routes->setGet('/', 'App\Modules\Home\HomeController::indexAction');


return $routes;
