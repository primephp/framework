<?php

namespace Prime\Server\Http;

use Prime\Controller\Resolver;
use Prime\EventDispatcher\Dispatcher;
use Prime\Server\Listener\KernelExceptionListener;
use Prime\Server\Routing\RouteCollection;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

/**
 * Descrição da Classe Kernel
 *
 * @author TomSailor
 * @name Kernel
 * @package Prime\Server\Http
 * @createAt 16/07/2015
 */
class Kernel {

    /**
     * Store unique instance from Kernel
     * @var static
     */
    private static $instance = null;

    /**
     * Store Request object
     * @var Request
     */
    private $request;

    /**
     * Store Event Dispatcher object
     * @var EventDispatcher 
     */
    private $dispatcher;

    /**
     * Store UrlMatcher object
     * @var UrlMatcher
     */
    private $matcher;

    /**
     * Store RouteCollection object
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * Store RequestContext object
     * @var RequestContext 
     */
    private $requestContext;

    private function __construct($routes) {

        $this->routeCollection = $routes;
        $this->request = Request::createFromGlobals();

        $this->requestContext = new RequestContext();
        $this->matcher = new UrlMatcher($routes, $this->requestContext->fromRequest($this->getRequest()));

        $this->dispatcher = new Dispatcher();
        $this->dispatcher->addSubscriber(new RouterListener($this->matcher));
        $this->dispatcher->addSubscriber(new KernelExceptionListener());
        $this->dispatcher->addSubscriber(new ResponseListener('UTF-8'));
    }

    /**
     * Returns a single instance of the application Kernel
     * @return Kernel
     */
    public static function getInstance($routes) {
        if (is_null(static::$instance)) {
            static::$instance = new static($routes);
        }
        return static::$instance;
    }

    /**
     * Return request object
     * @return Request
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * Return Event Dispatcher object
     * @return EventDispatcher
     */
    public function getDispatcher() {
        return $this->dispatcher;
    }

    /**
     * Return RouteCollection object
     * @return RouteCollection
     */
    public function getRouteCollection() {
        return $this->routeCollection;
    }

    /**
     * Return RequestContext object
     * @return RequestContext
     */
    public function getRequestContext() {
        return $this->requestContext;
    }

    public function handle() {
        $resolver = new Resolver();
        $kernel = new HttpKernel($this->getDispatcher(), $resolver);

        $response = $kernel->handle($this->getRequest());
        $response->send();

        $kernel->terminate($this->getRequest(), $response);
    }

}
