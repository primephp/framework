<?php

namespace Prime\Http;

/**
 * Descrição de Client
 * @name Client
 * @package Prime\Http
 * @version 1.0
 * @since 05/06/2012
 * @access public
 * @author tom
 */
class Client {

    private $navegador;

    /**
     * Classe para obtenção de informações do cliente da requisição 
     */
    public function __construct() {
        
    }

    public static function isIE() {
        if (ereg('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}


