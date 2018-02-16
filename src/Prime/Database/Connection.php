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
use PDOException;
use RuntimeException;

/**
 * Abre uma conexão com o banco de dados
 *
 * @author Elton Luiz
 */
abstract class Connection
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
    private static $keys = ['type', 'user', 'pass', 'name', 'host', 'port', 'charset', 'params'];

    public static function config(array $conn_var)
    {
        foreach ($conn_var as $key => $value) {
            $dbConfig = new \Prime\Database\DatabaseSetting();
            $dbConfig->setType($value['type'] ?? NULL);
            $dbConfig->setCharset($value['charset'] ?? NULL);
            $dbConfig->setHost($value['host'] ?? NULL);
            $dbConfig->setName($value['name'] ?? NULL);
            $dbConfig->setPass($value['pass'] ?? NULL);
            $dbConfig->setPort($value['port'] ?? NULL);
            $dbConfig->setUser($value['user'] ?? NULL);
            $dbConfig->setParams($value['params'] ?? NULL);
            self::$config[$key] = $dbConfig;
        }

        return self::$config;
    }

    public static function open($connectionName = 'default')
    {
        $conn = self::$conn[$connectionName] ?? NULL;

        if ($conn instanceof PDO) {
            return $conn;
        }

        $config = self::$config[$connectionName];

        // lê as informações contidas no arquivo
        $user = $config->getName();
        $pass = $config->getPass();
        $name = $config->getName();
        $host = $config->getHost();
        $type = $config->getType();
        $port = $config->getPort();
        $charset = $config->getCharset();
        $params = $config->getParams();

        $conn = NULL;

        // descobre qual o tipo (driver) de banco de dados a ser utilizado
        switch ($type) {
            case 'pgsql':
                if (is_null($port)) {
                    $port = '5432';
                }
                $conn = new PDO("pgsql:dbname={$name}; user={$user}; password={$pass};
                        host=$host;port={$port}");
                break;
            case 'mysql':
                $port = $port ? $port : '3306';
                $option = [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset"];
                $conn = new PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $pass, $option);
                break;
            case 'sqlite':
                $conn = new PDO("sqlite:{$name}");
                break;
            case 'ibase':
                $conn = new PDO("firebird:dbname={$name}", $user, $pass);
                break;
            case 'oci':
                $conn = new PDO("oci:dbname={$name}", $user, $pass);
                break;
            case 'mssql':
                $conn = new PDO("mssql:host={$host},1433;dbname={$name}", $user, $pass);
                break;
        }

        if (!is_object($conn)) {
            throw new PDOException('Falha na conexao com a base de dados.');
        }

        foreach ($params as $key => $value) {
            $conn->setAttribute($key, $value);
        }

        // retorna o objeto instanciado.
        /**
         * @var PDO 
         */
        self::$conn[$connectionName] = $conn;

        return self::$conn[$connectionName];
    }

    public static function get($connName = 'default')
    {
        //dd(self::$config);
        if (isset(self::$pool[$connName])) {
            return self::$pool[$connName];
        }
        if (isset(self::$config[$connName])) {
            return self::open($connName);
        }
        throw new RuntimeException(sprintf("Conexão %s não configurada", $connName));
    }

}
