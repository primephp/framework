<?php

namespace Prime\Server\Http;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
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
     *
     * @var Kernel
     */
    private static $instance = NULL;

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

    private function __construct($routes) {

        $this->request = Request::createFromGlobals();

        $this->matcher = new UrlMatcher($routes, new RequestContext($this->getRequest()));

        $this->dispatcher = new EventDispatcher();
        $this->dispatcher->addSubscriber(new RouterListener($this->matcher));
    }

    /**
     * Returns a single instance of the application Kernel
     * @return Kernel
     */
    public static function getInstance($routes) {
        if (is_null(self::$instance)) {
            self::$instance = new Kernel($routes);
        }
        return self::$instance;
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

    public function handle() {
        $resolver = new ControllerResolver();
        $kernel = new HttpKernel($this->getDispatcher(), $resolver);

        $response = $kernel->handle($this->getRequest());
        $response->send();

        $kernel->terminate($this->getRequest(), $response);
    }
    
    public function database(){
        
    }
    
    public function view(){
        
    }

}
