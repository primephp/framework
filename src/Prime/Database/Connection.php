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

/**
 * Abre uma conexão com o banco de dados
 *
 * @author Elton Luiz
 */
final class Connection
{

    /**
     * Array contendo as conexões ativas
     * @var PDO[]
     */
    private static $conn = [];

    /**
     * Array contendo a configuração de conexão com a base de dados da aplicação
     * @var array
     */
    private static $config;

    private function __construct()
    {
        throw new \Prime\Core\Exceptions\InvalidContextException();
    }

    public static function config($params, $dbName = NULL)
    {
        if (!is_array($params) && !strpos(':', $params)) {
            throw new \Prime\Core\Exceptions\InvalidParamException('Parêmetro inválido. Esperado um array ou uma string no formato "type:host:user:passwd:name:port:charset"');
        }

        if (is_string($params)) {
            $params = self::paramsToArray($params);
        }
        if (is_null($dbName)) {
            $db = md5($str);
        }
    }

    /**
     * 
     * @param string $params
     * @return array
     */
    private static function paramsToArray($params)
    {
        $var = explode(':', $params);

        $conn_var = [];
        $conn_var['type'] = $var[0];
        $conn_var['host'] = $var[1];
        $conn_var['user'] = $var[2];
        $conn_var['pass'] = $var[3];
        $conn_var['name'] = $var[4];
        $conn_var['port'] = isset($var[5]) ? $var[5] : NULL;
        $conn_var['charset'] = isset($var[6]) ? $var[6] : NULL;
        return $conn_var;
    }

}
