<?php

use Prime\Server\Http\Response;
use Prime\Server\Routing\RouteCollection;
use Prime\View\Template;

$routes = new RouteCollection();


$routes->setGet('/', 'App\Modules\Home\HomeController::indexAction');

$routes->setGet('/teste', function(){
    return new Response('teste Existe');
});


return $routes;
