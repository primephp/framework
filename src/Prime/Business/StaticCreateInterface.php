<?php

namespace Prime\Business;

/**
 * Define uma interface de criação de objetos por métodos também estáticos
 * facilitando a criação de objetos por uma só linha de código.
 * @package Prime\Business
 * @author tom
 */
interface StaticCreateInterface {

    /**
     * Método abstrático do qual em sua implementação deverá criar o objeto e 
     * retornar o mesmo para facilitação da chamada de seus métodos através de
     * uma única linha de código
     */
    public static function create();
}
