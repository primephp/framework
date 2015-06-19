<?php

namespace Prime\Http;

/**
 * Descrição da Classe Request
 * Manipula as requisições do usuário
 * @name Request
 * @package Prime\Http
 * @version 1.0
 * @author TomSailor
 * @since 12/09/2011
 * @access public
 */
class Request {

    private $_vars;

    /**
     * 
     */
    public function __construct() {
        if (filter_input_array(INPUT_GET)) {
            foreach (filter_input_array(INPUT_GET) as $key => $value) {
                $this->_vars[$key] = $value;
            }
        }

        if (filter_input_array(INPUT_POST)) {
            foreach (filter_input_array(INPUT_POST) as $key => $value) {
                $this->_vars[$key] = $value;
            }
        }

        if ($_FILES) {
            foreach ($_FILES as $key => $value) {
                $this->_vars[$key] = $value;
            }
        }
    }

    /**
     * Retorna o valor da variável de acordo com o nome passdo
     * @param string $name Nome da Variável 
     */
    public function getParameter($name) {
        if (isset($this->_vars[$name])) {
            return $this->_vars[$name];
        } else {
            return FALSE;
        }
    }

    /**
     * Retorna todos os Parâmetros no formato de
     * um array 
     * @return array 
     */
    public function getVariables() {
        return $this->_vars;
    }

    /**
     * Retorna todas as variáveis armazenadas no formato
     * URL
     */
    public function getQueryString() {
        return http_build_query($this->_vars);
    }

    /**
     * Retorna o total de parâmetros recuperados
     * @return int 
     */
    public function getRequestSize() {
        return count($this->_vars);
    }

    public static function isAjax() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
    }

}

