<?php

namespace Prime\Model\DAO;

use Exception,
    PDO;

/**
 * classe TConnection
 * @package Prime\Model\DAO
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
     * não existirão instâncias de TConnection, por isto estamos marcando-o como private
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

            $conn_var['type'] = $var[0];
            $conn_var['host'] = $var[1];
            $conn_var['user'] = $var[2];
            $conn_var['pass'] = $var[3];
            $conn_var['name'] = $var[4];
            $conn_var['port'] = $var[5] || NULL;
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

        // descobre qual o tipo (driver) de banco de dados a ser utilizado
        switch ($type) {
            case 'pgsql':
                $port = $port ? $port : '5432';
                $conn = new PDO("pgsql:dbname={$name}; user={$user}; password={$pass};
                        host=$host;port={$port}");
                break;
            case 'mysql':
                try {
                    $port = $port ? $port : '3306';
                    $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
                    $conn = new PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $pass, $option);
                } catch (Exception $e) {
                    trigger_error($e->getMessage(), E_USER_ERROR);
                    exit;
                }
                break;
            case 'sqlite':
                $conn = new PDO("sqlite:{$name}");
                break;
            case 'ibase':
                $conn = new PDO("firebird:dbname={$name}", $user, $pass);
                break;
            case 'oci8':
                $conn = new PDO("oci:dbname={$name}", $user, $pass);
                break;
            case 'mssql':
                $conn = new PDO("mssql:host={$host},1433;dbname={$name}", $user, $pass);
                break;
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
            throw new Exception('Não há conexão ativa');
        }
    }

}

