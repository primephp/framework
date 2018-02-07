<?php

namespace Prime\Model\DataSource;

use PDO;
use PDOException;

/**
 * classe Connection
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
     * Armazena um array de objetos contendo as configurações de conexão às
     * bases de dados
     * @var \Prime\Database\DatabaseSetting[]
     */
    private static $config = [];

    /**
     * método __construct()
     * não existirão instâncias de Connection, por isto estamos marcando-o como private
     */
    private function __construct() {
        
    }

    /**
     * Configura os dados para conexão com a base de dados da aplicação
     * @param array|string $conn_var
     */
    public static function config($conn_var) {
        foreach ($conn_var as $key => $value) {
            $dbConfig = new \Prime\Database\DatabaseSetting();
            $dbConfig->setType($value['type'] ?? NULL);
            $dbConfig->setCharset($value['charset'] ?? NULL);
            $dbConfig->setHost($value['host'] ?? NULL);
            $dbConfig->setName($value['name'] ?? NULL);
            $dbConfig->setPass($value['pass'] ?? NULL);
            $dbConfig->setPort($value['port'] ?? NULL);
            $dbConfig->setUser($value['user'] ?? NULL);
            self::$config[$key] = $dbConfig;
        }

        return self::$config;
    }

    /**
     * método open()
     * recebe um String de Conexão, no formato:<br/>
     * type:host:user:passwd:name:port
     * ou um array associativo com as supracitadas chaves
     * @return PDO
     */
    public static function open($connectionName = 'default') {
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
                $option = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset"];
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
        self::$conn[$connectionName] = $conn;

        return self::$conn[$connectionName];
    }

    /**
     * Retorna a conexão ativa
     * @return PDO
     */
    public static function get($connectionName = 'default') {
        // retorna a conexão ativa
        if (!empty(self::$conn[$connectionName])) {
            return self::$conn[$connectionName];
        } else {
            throw new PDOException('Não há conexão ativa');
        }
    }

}
