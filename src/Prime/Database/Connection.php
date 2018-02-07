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

    public static function config(array $params)
    {
        self::$config = $params;
    }

    public static function open($connName = 'default')
    {
        // lê as informações contidas no arquivo
        $user = self::$config[$connName]['user'] ?? NULL;
        $pass = self::$config[$connName]['pass'] ?? NULL;
        $name = self::$config[$connName]['name'] ?? NULL;
        $host = self::$config[$connName]['host'] ?? NULL;
        $type = self::$config[$connName]['type'] ?? NULL;
        $port = self::$config[$connName]['port'] ?? NULL;
        $charset = self::$config[$connName]['charset'] ?? 'utf8';

        $conn = NULL;

        // descobre qual o tipo (driver) de banco de dados a ser utilizado
        switch ($type) {
            case 'pgsql':
                if (is_null($port)) {
                    $port = '5432';
                }
                $conn = new PDO("pgsql:dbname={$name}; user={$user}; password={$pass};
                        host=$host;port={$port}");
                if (!empty($charset)) {
                    $conn->exec("SET CLIENT_ENCODING TO '{$charset}';");
                }
                break;
            case 'mysql':
                $port = $port ? $port : '3306';
                if ($charset == 'utf8') {
                    $charset = 'utf8mb4';
                }
                $option = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset"];
                $conn = new PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $pass, $option);
                break;
            case 'sqlite':
            case 'fbird':
                $conn = new PDO("sqlite:{$name}");
                break;
            case 'ibase':
                $conn = new PDO("firebird:dbname={$name}", $user, $pass);
                break;
            case 'oci':
            case 'oci8':
            case 'oracle':
                $conn = new PDO("oci:dbname={$name}", $user, $pass);
                break;
            case 'mssql':
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $conn = new PDO("sqlsrv:Server={$host};Database={$name}", $user, $pass);
                } else {
                    if ($port) {
                        $conn = new PDO("dblib:host={$host}:{$port};dbname={$name}", $user, $pass);
                    } else {
                        $conn = new PDO("dblib:host={$host};dbname={$name}", $user, $pass);
                    }
                }
                $conn = new PDO("mssql:host={$host},1433;dbname={$name}", $user, $pass);
                break;
            case 'dblib':
                $port = $port ? $port : '1433';
                $conn = new PDO("dblib:host={$host},{$port};dbname={$name}", $user, $pass);
                break;
            default:
                throw new Exception("Drive não encontrado para o tipo" . ': ' . $type);
        }

        if (!is_object($conn)) {
            throw new PDOException('Falha na conexao com a base de dados.');
        }

        // define para que o PDO lance exceções na ocorrência de erros
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        //PARA DEBUGAR COM O BANCO DE DADOS
        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $conn->setAttribute(PDO::ATTR_CURSOR, PDO::CURSOR_FWDONLY);

        // retorna o objeto instanciado.
        /**
         * @var PDO 
         */
        self::$pool[$connName] = $conn;

        return self::$pool[$connName];
    }

    public static function get($connName = 'default')
    {
        if (isset(self::$pool[$connName])) {
            return self::$pool[$connName];
        }
        if (isset(self::$config[$connName])) {
            return self::open($connName);
        }
        throw new RuntimeException(sprintf("Conexão com %s não configurada", $connName));
    }

}
