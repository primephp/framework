<?php

namespace Prime\Core;

use Prime\Http\Router;

/**
 * Descrição de TApplication
 * esta classe não pode ser extendida
 * @author TomSailor
 * @package Prime\Core
 */
abstract class TApplication {
    
    private function __construct() {
        
    }

    public static function main() {
        $router = new Router();

        //$router->debug();
        $router->execute();
    }

}