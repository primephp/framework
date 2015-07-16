<?php

namespace Prime\Server\Http;

use App\Config\AppConfig;
use Prime\Html\Base\HTMLScript;
use Prime\Util\Collection\ArrayList as ArrayList;

/**
 * Descrição da Classe URL
 * @name URL
 * @package Prime\Http
 * @author TomSailor
 * @since 18/08/2011 / 07/05/2014
 * @access public
 */
class Url {

    private $controller = NULL;
    private $action = NULL;
    private $fragment = NULL;

    /**
     * Variável do Tipo ArrayList
     * Que armazena os parâmetros para a
     * queryString
     * @var ArrayList 
     */
    private $params;

    /**
     * Método COntrutor
     * Se passados os parâmtros defines no Objeto
     * @param string $controller
     * @param string $action
     * @param string $params 
     */
    public function __construct($controller = null, $action = null, $params = array()) {
        if (!empty($controller)) {
            $this->controller = $controller;
        }

        if (!empty($action)) {
            $this->action = $action;
        }

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $this->params[urlencode($key)] = urlencode($value);
            }
            $this->params = $params;
        }
    }

    /**
     * Define o nome do Controller a ser utilizado
     * @param string $controller 
     */
    public function setController($controller) {
        $this->controller = $controller;
    }

    /**
     * Define o noma da Action a ser utilizada
     * @param string $action 
     */
    public function setAction($action) {
        $this->action = $action;
    }

    /**
     * Define um parâmetro e seu valor a ser passado
     * para a URL a ser criada
     * @param string $param nome do Parâmetro
     * @param string $value Valor do Parâmetro
     */
    public function setParam($param, $value) {
        $param = urlencode($param);
        $value = urlencode($value);
        $this->params[$param] = $value;
    }

    public function setParams(ArrayList $array) {
        $this->params = $array->getElements();
    }

    /**
     * Métod fetchURLString
     * Retorna já formatada os parâmtros da URL
     * @return string | false
     */
    private function fetchURLString() {
        if (!empty($this->params)) {
            return "?" . urldecode(http_build_query($this->params));
        } else {
            return false;
        }
    }

    /**
     * Método getRequest()
     * Pega a requisição em forma de URL
     * @return type 
     */
    public function queryString() {
        $return = NULL;
        //se não for um valor nulo passa o nome do controller para retorno
        if (!empty($this->controller)) {
            $return = '/';
            $return .= $this->controller;
        }
        //se não for um valor nulo passa o nome da ACTION para retorno
        if (!empty($this->action)) {
            $return.= '/';
            $return .= $this->action . AppConfig::getVariable('sufix', 'default');
        }

        //Adiciona se houver a query de parâmetros
        $return .= $this->fetchURLString();
        if ($this->fragment) {
            $return .=$this->getFragment();
        }

        return str_replace('&amp;', '&', $return);
    }

    /**
     * Método send()
     * Redireciona para URL de acordo com os
     * Parâmetros passados anteriormente como
     * o Controller, Action e os Parâmetros
     * @param integer $tempo 
     */
    public function send($tempo = null) {

        if ($tempo > 0) {
            header("Content-Type: text/html; chatset=UTF-8", false);
            header("Refresh: $tempo; URL=" . $this->queryString());
        } else {
            header("Location:" . $this->queryString());
            exit;
        }
    }

    /**
     * 
     */
    public static function refresh() {
        $script = new HTMLScript();
        $script->appendChild("window.location.reload(true);");
        $script->printOut();
    }

    /**
     * Retorna a URL completa inclusindo o endereço do site
     */
    public function getUrl() {
        $server = new Server();

        $nome = $server->requestHttp() . $server->serverName();

        return $nome . $this->queryString();
    }

    /**
     * Retorna o fragmento definido 
     * @return string <p>#fragment<p>
     */
    private function getFragment() {
        return '#' . $this->fragment;
    }

    /**
     * Define o framento da URL
     * @param string $frag
     */
    public function setFragment($frag) {
        if (is_string($frag)) {
            $this->fragment = $frag;
        }
    }

}
