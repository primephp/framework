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
     * Returns the url as a string
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
     * Sets the value for the parameter to be used for the creation of Url 
     * @param string $name The param name
     * @param string $value The param value
     */
    public function setParam($name, $value) {
        $this->_params[$name] = $value;
    }

    /**
     * Returns the value of the parameter, if given, according to the name 
     * passed as a parameter in the method
     * @param string $name
     * @return mixed
     */
    public function getParam($name) {
        if (isset($this->_params[$name])) {
            return $this->_params[$name];
        }
        return null;
    }

    /**
     * Returns a string identifying the Url to be created
     * @return string
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * Returns an array containing the parameters for the creation of Url
     * @return array
     */
    public function getParams() {
        return $this->_params;
    }

}
