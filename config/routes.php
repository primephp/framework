<?php

use App\Modules\Index\Controller\IndexPageController;

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

/* * *****************************************************************************
 * HOME / INDEX
 * **************************************************************************** */
$routes->setGet('/', IndexPageController::class, 'index');


return $routes;
