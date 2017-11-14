<?php

/*
 * The MIT License
 *
 * Copyright 2017 Elton Luiz.
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

namespace Prime\Database;

use PDO;
use Prime\Core\Exceptions\InvalidContextException;
use Prime\Core\Exceptions\InvalidParamException;

/**
 * Abre uma conexão com o banco de dados
 *
 * @author Elton Luiz
 */
final class Connection
{

    /**
     * Pool contendo as conexões ativas
     * @var PDO[]
     */
    private static $pool = [];

    /**
     * Array contendo as configurações de conexão com as bases de dados
     * @var array
     */
    private static $config = [];

    private function __construct()
    {
        throw new InvalidContextException();
    }

    public static function config($params, $dbName = 'default')
    {
        if (!is_array($params) && !strpos(':', $params)) {
            throw new InvalidParamException('Parêmetro inválido. Esperado um array ou uma string no formato "type:host:user:passwd:name:port:charset"');
        }

        if (is_string($params)) {
            $params = self::paramsToArray($params);
        }
        
    }
}
