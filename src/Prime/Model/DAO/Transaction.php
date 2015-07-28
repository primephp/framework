<?php

namespace Prime\Model\DAO;

use Prime\Register\Logger\TLogger,
    PDO,
    PDOStatement;

/**
 * classe Transaction
 * @name Transaction
 * @package Prime\Model\DAO
 * esta classe provém os métodos necessários para manipular transações
 */
final class Transaction {

    /**
     * Armazena a Transação ativa
     * @var PDOStatement
     */
    private static $conn;
    private static $sqlStatement;

    /**
     * método __construct()
     * Está declarado como private para impedir que se crie instâncias de Transaction
     */
    private function __construct() {
        
    }

    /**
     * método open()
     * Abre uma transação e uma conexão ao BD
     * recebe um String de Conexão, no formato:<br/>
     * type:host:user:passwd:name:port
     * ou um array associativo com as supracitadas chaves
     */
    public static function open($database) {
        // abre uma conexão e armazena na propriedade Estática $conn
        if (empty(self::$conn)) {
            self::$conn = Connection::open($database);
        }
        // inicia a transação
        self::$conn->beginTransaction();
        // desliga o log de SQL
        self::$logger = NULL;
        return self::$conn;
    }

    /**
     * Retorna a conexão ativa
     * @return PDO
     */
    public static function get() {
        // retorna a conexão ativa
        return self::$conn;
    }

    /**
     * método rollback()
     * desfaz todas operações realizadas na transação
     */
    public static function rollback() {
        if (self::$conn) {
            // desfaz as operações realizadas durante a transação
            self::$conn->rollback();
            self::$conn = NULL;
        }
    }

    /**
     * método close()
     * Aplica todas operações realizadas e fecha a transação
     */
    public static function close() {
        if (self::$conn) {
            // aplica as operações realizadas
            // durante a transação
            self::$conn->commit();
            self::$conn = NULL;
        }
    }

    public static function getSqlStatement() {
        return self::$sqlStatement;
    }

}
