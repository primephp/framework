<?php

namespace Prime\Http;

/**
 * Descrição da Classe Server
 * Classe para encapsulamento da variável
 * $_SERVER, no qual define métodos de acesso
 * aos valores de seus índices
 * @package Prime\Http
 * @author TomSailor
 * @since 03/08/2011
 */
class Server {

    private $value = null;

    public function __construct() {
        if (isset($_SERVER) && is_array($_SERVER)) {
            $this->value = $_SERVER;
        } else {
            trigger_error('Variável $_SERVER não foi definida ou não contém valores', E_WARNING);
        }
    }

    private function execute($index) {
        if (isset($this->value[$index])) {
            return $this->value[$index];
        } else {
            trigger_error('Índice ' . $index . ' não disponível na variável $_SERVER.', E_USER_ERROR);
            return false;
        }
    }

    public function httpHost() {
        return $this->execute('HTTP_HOST');
    }

    /**
     * Retorna o navegador
     * @return type 
     */
    public function userNavigator() {
        return $this->execute('HTTP_USER_AGENT');
    }

    public function httpCookie() {
        return $this->execute('HTTP_COOKIE');
    }

    /**
     * Retorna o nome host do servidor onde o script está em execução
     * @return <type>
     */
    public function serverName() {
        return $this->execute('SERVER_NAME');
    }

    /**
     * Retorna o IP do servidor onde está o script em execução
     * @return <type>
     */
    public function serverAddr() {
        return $this->execute('SERVER_ADDR');
    }

    /**
     * Retorna o IP de quem está acessando a aplicação
     * @return type 
     */
    public function remoteAddr() {
        return $this->execute('REMOTE_ADDR');
    }

    public function redirectUrl() {
        return $this->execute('REDIRECT_URL');
    }

    /**
     * Retorna a Raiz do Documento
     * @return type 
     */
    public function documentRoot() {
        return $this->execute('DOCUMENT_ROOT');
    }

    /**
     * Retorna o Método de Requisiçao
     * @return type 
     */
    public function requestMethod() {
        return $this->execute('REQUEST_METHOD');
    }

    /**
     * Retorna a String de Consulta
     * @return string 
     */
    public function queryString() {
        return $this->execute('QUERY_STRING');
    }

    /**
     * Retorna a URI requisitada
     * Identificador Uniforme de Recursos (URI) (Uniform Resource Identifier (em inglês))
     * @return string 
     */
    public function requestUri() {
        return $this->execute('REQUEST_URI');
    }

    /**
     * Retorna a string 'http://'
     * @return string 
     */
    public function requestHttp() {
        return 'http://';
    }

}

