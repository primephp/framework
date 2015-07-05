<?php

namespace Prime\Server\Http;

use App\Config\AppConfig;
use Prime\Core\Object;
use Prime\Server\Http\Server;
use Prime\Pattern\Singleton\ISingleton;

/**
 * Descrição de HttpUri
 * @package Http
 * @create 02/12/2013
 * @author tom
 */
class HttpUri extends Object implements ISingleton {

    /**
     * Armazena a string que define a URI passada ou capturada
     * @var str A URI 
     */
    private $_value;
    protected static $_instance = NULL;
    private $_controller = NULL;
    private $_action = NULL;
    private $_params = array();

    /**
     * Método construtor privado para impedir que seja instanciado mais de 
     * objeto do tipo HttpRui
     * @param str $uri
     */
    private function __construct($uri = NULL) {
        $this->_value = $this->defineUri($uri);
        $this->setUri($uri);
        $this->prepare();
    }

    /**
     * Retorna uma instância de HttpUri, podendo ser passado ou não uma string
     * de Uri.
     * @example NULL /controller/action.html?id=1234&outro=567&other=890
     * @param str $uri
     * @return HttpUri
     */
    public static function getInstance($uri = NULL) {
        if (is_null(self::$_instance)) {
            self::$_instance = new HttpUri($uri);
        }
        return self::$_instance;
    }
    
    /**
     * Retorna o uri no formato string
     * @return str
     */
    public function getValue(){
        return $this->_value;
    }

    public function setUri($uri = NULL) {
        $this->_value = $this->defineUri($uri);
    }

    /**
     * Define a URI, caso do parâmetro passado seja NULO, pega a URI definida
     * pelo parâmetro HTTP URI do objeto Server
     * @param str $uri
     * @return str
     */
    private function defineUri($uri = NULL) {
        if (is_null($uri)) {
            $server = new Server();
            $this->_value = $server->requestUri();
        } else {
            $this->_value = $uri;
        }
        return $this->_value;
    }

    private function prepare() {
        $clean = array('\\', '/../', '//', './', '/index.php');
        $url = trim(str_replace($clean, '', $this->_value), '/');
        $exploded = explode('?', $url);
        $array = explode('/', $exploded[0]);

        if (current($array)) {
            $this->_controller = $this->cleaner(current($array));
            next($array);
        }

        if (current($array)) {
            $this->_action = $this->cleaner(current($array));
            next($array);
        }

        if (isset($exploded[1])) {
            $this->prepareQueryString($exploded[1]);
        }
    }

    public function debug() {
        $this->prepare();

        echo '<pre>';

        $another = array('controller' => $this->getUriController(), 'action' => $this->getUriAction(),
            'params' => $this->getUriParameters());

        var_dump($another);
    }

    private function prepareQueryString($query) {
        $parameters = explode('&', $query);
        foreach ($parameters as $value) {
            $value = explode('=', $value);
            if (is_array($value)) {
                $this->_params[$value[0]] = (isset($value[1]) ? $value[1] : NULL);
            } else {
                $this->_params[] = $value[0];
            }
        }
    }

    private function cleaner($value) {
        return str_replace(AppConfig::acceptableSuffix(), '', $value);
    }
    
    /**
     * Retorna a Url da requisição
     * @return string
     */
    public function getUrl(){
        return $this->_value;
    }

    /**
     * Retorna o nome do controller definido na URI, caso não esteja nenhum
     * controller definido retorna NULL;
     * @return str | NULL
     */
    public function getUriController() {
        return $this->_controller;
    }

    /**
     * Retorna o nome da action defina na URI, caso não esteja nenhuma action
     * definida retorna NULL
     * @return str | NULL
     */
    public function getUriAction() {
        return $this->_action;
    }

    /**
     * Retorna um array associativo contendo os ítens da QueryString
     * relativos ao URI
     * @return array
     */
    public function getUriParameters() {
        return $this->_params;
    }

    /**
     * Retorna o valor do item da QueryString de acordo com o nome passado
     * como parâmetro, caso não esteja setado, retorna NULL
     * @param str $paramName O nome do parâmetro do qual deseja-se o valor
     * @return str | NULL
     */
    public function getUriParam($paramName) {
        if (isset($this->_params[$paramName])) {
            return $this->_params[$paramName];
        } else {
            return NULL;
        }
    }

    public function getQueryString() {
        return http_build_query($this->_params);
    }

}
