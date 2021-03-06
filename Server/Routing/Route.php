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

use Symfony\Component\Routing\Route as BaseRoute;

/**
 * Descrição da Classe Route
 *
 * @name Route
 * @package Prime\Server\Routing
 * @createAt 18/07/2015
 * @author Elton Luiz
 */
class Route extends BaseRoute
{

    /**
     * Define um nome para a rota;
     * @var string
     */
    protected $name;

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Retorna o nome da rota 
     * @return string
     */
    public function getName($method = 'GET')
    {
        if (!is_null($this->name)) {
            return $this->name;
        } else {
            $method = strtolower($method);
        }
        $path = $this->getPath();
        $name = '';
        $r = explode('/', $path);
        foreach ($r as $value) {
            if (!empty($value) && $value[0] != '{') {
                if (!empty($name)) {
                    $name .= '_';
                }
                $name .= $value;
            }
        }
        return $name . '_' . $method;
    }

}
