<?php

namespace Prime\Model\DataSource;

use PDO;
use PDOException;

/**
 * classe TConnection
 * @package Prime\Model\DataSource
 * gerencia conexões com bancos de dados através de arquivos de configuração.
 */
final class Connection {

    /**
     * Armazena a Transação ativa
     * @var PDO
     */
    private static $conn;

    /**
     * método __construct()
     * não existirão instâncias de Connection, por isto estamos marcando-o como private
     */
    private function __construct() {
        
    }

    /**
     * método open()
     * recebe um String de Conexão, no formato:<br/>
     * type:host:user:passwd:name:port
     * ou um array associativo com as supracitadas chaves
     * @return PDO
     */
    public static function open($conn_var) {
        if (is_string($conn_var)) {
            $var = explode(':', $conn_var);

            $conn_var = array();
            $conn_var['type'] = $var[0];
            $conn_var['host'] = $var[1];
            $conn_var['user'] = $var[2];
            $conn_var['pass'] = $var[3];
            $conn_var['name'] = $var[4];
            $conn_var['port'] = isset($var[5]) ? $var[5] : NULL;
        }
        if (!is_array($conn_var)) {
            trigger_error('Parâmetro inválido. ' . __METHOD__, E_USER_ERROR);
        }

        // lê as informações contidas no arquivo
        $user = isset($conn_var['user']) ? $conn_var['user'] : NULL;
        $pass = isset($conn_var['pass']) ? $conn_var['pass'] : NULL;
        $name = isset($conn_var['name']) ? $conn_var['name'] : NULL;
        $host = isset($conn_var['host']) ? $conn_var['host'] : NULL;
        $type = isset($conn_var['type']) ? $conn_var['type'] : NULL;
        $port = isset($conn_var['port']) ? $conn_var['port'] : NULL;

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
                $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
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
        self::$conn = $conn;

        return self::$conn;
    }

    /**
     * Retorna a conexão ativa
     * @return PDO
     */
    public static function get() {
        // retorna a conexão ativa
        if (!empty(self::$conn)) {
            return self::$conn;
        } else {
            throw new PDOException('Não há conexão ativa');
        }
    }

}
