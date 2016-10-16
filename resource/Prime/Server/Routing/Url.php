<?php

namespace Prime\Server\Routing;

use Prime\Server\Http\Application;
use Symfony\Component\Routing\Generator\UrlGenerator;

/**
 * Descrição da Classe Url
 *
 * @name Url
 * @package Prime\Server\Routing
 * @createAt 23/10/2015
 * @author Tom Sailor
 */
class Url {

    /**
     * Stores the single instance of the URL object
     * @var static
     */
    private static $_instance = null;
    private $_name = null;

    /**
     * Stores an array of parameters for configuring the URL
     * @var array 
     */
    private $_params = [];
    private $routeCollection = null;
    private $requestContext = null;

    /**
     * Stores the UrlGenerator instance used in this creation of URL
     * @var UrlGenerator
     */
    private $urlGenerator = null;

    public function __construct($name) {
        $this->_name = $name;
        if (is_null($this->routeCollection) && is_null($this->requestContext)) {
            $kernel = Application::getInstance()->getKernel();
            $this->routeCollection = $kernel->getRouteCollection();
            $this->requestContext = $kernel->getRequestContext();
        }
        $this->urlGenerator = new UrlGenerator($this->routeCollection, $this->requestContext);
    }

    public function __toString() {
        return $this->toString();
    }

    /**
     * retorna a url como uma string
     * @return string
     */
    public function toString() {
        return $this->urlGenerator->generate($this->getName(), $this->getParams());
    }

    /**
     * Url returns the object to create the string that identifies the Url 
     * within the configured routes
     * @param string $name
     * @return static
     */
    public static function generate($name) {
        return new static($name);
    }

    /**
     * Define o valor para o parâmetro a ser utilizado para a criação da URL
     * @param string $name Nome do parâmetro
     * @param string $value O valor para o parâmetro
     */
    public function setParam($name, $value) {
        $this->_params[$name] = $value;
    }

    /**
     * Retorna o valor do parâmetro, se houver, de acordo o nome passado como
     * parâmetro
     * @param string $name O nome do parâmetro a ser retornado o seu valor
     * @return mixed
     */
    public function getParam($name) {
        if (isset($this->_params[$name])) {
            return $this->_params[$name];
        }
        return null;
    }

    /**
     * Retorna uma string que identifica a url a ser criada
     * @return string
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * Retorna um array contendo os parâmetros para a criação da Url
     * @return array
     */
    public function getParams() {
        return $this->_params;
    }

}
