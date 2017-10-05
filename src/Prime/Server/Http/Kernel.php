<?php

namespace Prime\Server\Http;

use Prime\Controller\Resolver;
use Prime\EventDispatcher\Dispatcher;
use Prime\Server\Listener\KernelExceptionListener;
use Prime\Server\Listener\RequestListener;
use Prime\Server\Routing\RouteCollection;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

/**
 * Descrição da Classe Kernel
 *
 * @author Elton Luiz
 * @name Kernel
 * @package Prime\Server\Http
 * @createAt 16/07/2015
 */
class Kernel
{

    /**
     * Armazena a instância única do Kernel
     * @var static
     */
    private static $instance = null;

    /**
     * Store Request object
     * @var Request
     */
    private $request;

    /**
     * Armazena o objeto Event Dispatcher
     * @var EventDispatcher 
     */
    private $dispatcher;

    /**
     * Armazena o objeto UrlMatcher
     * @var UrlMatcher
     */
    private $matcher;

    /**
     * Armazena o objeto RouteCollection
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * Armazena o objeto RequestContext
     * @var RequestContext 
     */
    private $requestContext;

    /**
     * Arzmena o objeto UrlGenerator
     * @var UrlGenerator 
     */
    private $generator;

    private function __construct($routes)
    {

        $this->routeCollection = $routes;
        $this->request = Request::createFromGlobals();

        $this->requestContext = new RequestContext();
        $this->matcher = new UrlMatcher($routes, $this->requestContext->fromRequest($this->getRequest()));

        $this->dispatcher = new Dispatcher();
        $this->dispatcher->addSubscriber(new RouterListener($this->matcher, new RequestStack()));
        $this->dispatcher->addSubscriber(new KernelExceptionListener());
        $this->dispatcher->addSubscriber(new RequestListener());
        $this->dispatcher->addSubscriber(new ResponseListener('UTF-8'));
    }

    /**
     * Returns a single instance of the application Kernel
     * @return Kernel
     */
    public static function getInstance($routes)
    {
        if (is_null(static::$instance)) {
            static::$instance = new static($routes);
        }
        return static::$instance;
    }

    /**
     * Return request object
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Return Event Dispatcher object
     * @return EventDispatcher
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * Return RouteCollection object
     * @return RouteCollection
     */
    public function getRouteCollection()
    {
        return $this->routeCollection;
    }

    /**
     * Return RequestContext object
     * @return RequestContext
     */
    public function getRequestContext()
    {
        return $this->requestContext;
    }

    public function handle()
    {
        $resolver = new Resolver();
        $kernel = new HttpKernel($this->getDispatcher(), $resolver);

        $response = $kernel->handle($this->getRequest());
        $response->send();

        $kernel->terminate($this->getRequest(), $response);
    }

}
