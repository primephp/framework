<?php

/*
 * The MIT License
 *
 * Copyright 2015 Elton Luiz.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Prime\Server\Routing;

use Symfony\Component\Routing\RouteCollection as BaseCollection;

/**
 * Descrição da Classe RouteCollection
 *
 * @name RouteCollection
 * @package Prime\Server\Routing
 * @createAt 18/07/2015
 * @author Elton Luiz
 */
class RouteCollection extends BaseCollection
{

    /**
     * Define uma rota para os métodos http GET, POST e HEAD
     * Podendo aceitar coringas
     * @param string $path o caminho da rota ex. /user/profile/{id}
     * @param callable $callable o callable que será chamado para a rota 
     * definida
     * @param string $name O nome para a Rota definida
     * @return \Prime\Server\Routing\Route
     */
    public function setRoute($path, $callable, $name = NULL)
    {
        $route = new Route($path);
        if (is_null($name)) {
            $name = $route->getName('MULTI');
        }
        $route->setDefault('_controller', $callable);
        $route->setMethods(['POST', 'GET', 'HEAD']);
        $this->add($name, $route);
        return $route;
    }

    /**
     * Define uma rota para o método http POST
     * Podendo aceitar coringas
     * @param string $path o caminho da rota ex. /user/save/{id}
     * @param callable $callable o callable que será chamado para a rota 
     * definida
     * @param string $name O nome para a rota definida
     * @return \Prime\Server\Routing\Route
     */
    public function setPost($path, $callable, $name = NULL)
    {
        $route = new Route($path);
        if (is_null($name)) {
            $name = $route->getName('POST');
        }
        $route->setDefault('_controller', $callable);
        $route->setMethods(['POST']);
        $this->add($name, $route);
        return $route;
    }

    /**
     * Define uma rota para o método http GET
     * Podendo aceitar coringas
     * @param string $path o caminho da rota ex. /user/profile/{id}
     * @param callable $callable o callable que será chamado para a rota 
     * definida
     * @param string $name O nome para a rota definida
     * @return \Prime\Server\Routing\Route
     */
    public function setGet($path, $callable, $name = NULL)
    {
        $route = new Route($path);
        if (is_null($name)) {
            $name = $route->getName('GET');
        }
        $route->setDefault('_controller', $callable);
        $route->setMethods(['GET']);
        $this->add($name, $route);
        return $route;
    }

}
