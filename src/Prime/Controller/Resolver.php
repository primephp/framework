<?php

namespace Prime\Controller;

use Closure;
use InvalidArgumentException;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionObject;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

/**
 * Classe Resolver <br>
 * 
 * @name Resolver
 * @package Prime\Controller
 * @author Elton Luiz
 * @createAt 02/08/2015
 */
class Resolver implements ControllerResolverInterface
{

    /**
     * 
     */
    public function __construct()
    {
        
    }

    /**
     * {@inheritdoc}
     *
     * This method looks for a '_controller' request attribute that represents
     * the controller name (a string like ClassName@MethodName).
     *
     * @api
     */
    public function getController(Request $request)
    {
        if (!$controller = $request->attributes->get('_controller')) {
            return false;
        }
        if (is_array($controller)) {
            return $controller;
        }

        if (is_object($controller)) {
            if (method_exists($controller, '__invoke')) {
                return $controller;
            }

            throw new InvalidArgumentException(sprintf('Controller "%s" para a URI "%s" não é callable.', get_class($controller), $request->getPathInfo()));
        }

        if (false === strpos($controller, '@')) {
            if (method_exists($controller, 'handler')) {
                return $this->instantiatePageController($request, $controller);
            } elseif (function_exists($controller)) {
                return $controller;
            }
        }
        $callable = $this->createController($controller);

        if (!is_callable($callable)) {
            throw new InvalidArgumentException(sprintf('Controller "%s" para a URI "%s" não é callable.', $controller, $request->getPathInfo()));
        }

        return $callable;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function getArguments(Request $request, $controller)
    {
        if (is_array($controller)) {
            $r = new ReflectionMethod($controller[0], $controller[1]);
        } elseif (is_object($controller) && ($controller instanceof AbstractPageController)) {
            $r = new ReflectionObject($controller);
            $r = $r->getMethod('__construct');
        } elseif (is_object($controller) && !$controller instanceof Closure) {
            $r = new ReflectionObject($controller);
            $r = $r->getMethod('__invoke');
        } else {
            $r = new ReflectionFunction($controller);
        }

        return $this->doGetArguments($request, $controller, $r->getParameters());
    }

    protected function doGetArguments(Request $request, $controller, array $parameters)
    {
        $attributes = $request->attributes->all();
        $arguments = [];
        foreach ($parameters as $param) {
            if (array_key_exists($param->name, $attributes)) {
                $arguments[] = $attributes[$param->name];
            } elseif ($param->getClass() && $param->getClass()->isInstance($request)) {
                $arguments[] = $request;
            } elseif ($param->isDefaultValueAvailable()) {
                $arguments[] = $param->getDefaultValue();
            } else {
                if (is_array($controller)) {
                    $repr = sprintf('%s@%s()', get_class($controller[0]), $controller[1]);
                } elseif (is_object($controller)) {
                    $repr = get_class($controller);
                } else {
                    $repr = $controller;
                }
                throw new RuntimeException(sprintf('Controller "%s" requer que você forneça um valor para o parâmetro "$%s" (porque não há nenhum valor padrão ou porque há um parâmetro não opcional após este).', $repr, $param->name));
            }
        }

        return $arguments;
    }

    protected function doGetPageControllerArguments(Request $request, $pageController)
    {
        $attributes = $request->attributes->all();
        $arguments = [];
        $r = new \ReflectionClass($pageController);
        $r = $r->getMethod('__construct');

        foreach ($r->getParameters() as $param) {
            if (array_key_exists($param->name, $attributes)) {
                $arguments[] = $attributes[$param->name];
            } elseif ($param->getClass() && $param->getClass()->isInstance($request)) {
                $arguments[] = $request;
            } elseif ($param->isDefaultValueAvailable()) {
                $arguments[] = $param->getDefaultValue();
            } else {
                if (is_array($pageController)) {
                    $repr = sprintf('%s@%s()', get_class($pageController[0]), $pageController[1]);
                } elseif (is_object($pageController)) {
                    $repr = get_class($pageController);
                } else {
                    $repr = $pageController;
                }
                throw new RuntimeException(sprintf('Controller "%s" requer que você forneça um valor para o parâmetro "$%s" (porque não há nenhum valor padrão ou porque há um parâmetro não opcional após este).', $repr, $param->name));
            }
        }
        return $arguments;
    }

    /**
     * Returns a callable for the given controller.
     *
     * @param string $controller A Controller string
     *
     * @return mixed A PHP callable
     *
     * @throws InvalidArgumentException
     */
    protected function createController($controller)
    {
        if (false === strpos($controller, '@')) {
            throw new InvalidArgumentException(sprintf('Não foi possível encontrar o controller "%s".', $controller));
        }
        list($class, $method) = explode('@', $controller, 2);

        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf('Classe "%s" não existe.', $class));
        }

        return [$this->instantiateController($class), $method];
    }

    /**
     * Retorna uma instância do PageController
     *
     * @param string $constroller O nome da Classe
     *
     * @return object
     */
    protected function instantiatePageController(Request $request, $constroller)
    {
        $args = $this->doGetPageControllerArguments($request, $constroller);
        $class = new \ReflectionClass($constroller);
        $class->newInstanceArgs($args);
        return $class->newInstanceArgs($args);
    }

    /**
     * Returns an instantiated controller
     *
     * @param string $class A class name
     *
     * @return object
     */
    protected function instantiateController($class)
    {
        $instance = new $class();
        /* @var $instance Request */

        return $instance;
    }

}
