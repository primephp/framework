<?php

namespace Prime\Server\Http;

/**
 * classe Session
 * @name Session
 * @package Prime\Http
 * gerencia uma sessão com o usuário
 */
class Session {

    protected static $instance = NULL;
    private $nome = NULL;

    /**
     * método construtor
     * inicializa uma sessão
     */
    public function __construct($nome = NULL) {
        if (!is_null($nome)) {
            $this->nome = $nome;
        }
        if (self::$instance === true) {
            return;
        } else {
            self::$instance = true;
            if (session_start()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function getInstance($nome = NULL) {
        if (is_null(self::$instance)) {
            self::$instance = new Session($nome);
        }
        return self::$instance;
    }

    /**
     * Método mágico __set
     * @param <type> $name
     * @param <type> $value
     */
    public function __set($name, $value) {
        if (is_array($value)) {
            if (!is_array($_SESSION[$name])) {
                $_SESSION[$name] = array();
            }
            foreach ($value as $key => $valor) {
                $_SESSION[$name][$key] = $valor;
            }
        } else {
            $_SESSION[$name] = $value;
        }
    }

    /**
     * Mètodo mágico __Get
     * @param <type> $name
     * @return <type>
     */
    public function __get($name) {
        return $_SESSION[$name];
    }

    /**
     * método setValue()
     * armazena uma variável na sessão
     * @param $var     = Nome da variável
     * @param $value = Valor
     */
    function setValue($var, $value) {
        if (!is_null($this->nome)) {
            $_SESSION[$this->nome][$var] = $value;
        } else {
            $_SESSION[$var] = $value;
        }
    }

    /**
     * Método addValue
     * Adiciona um valor a uma variável da Sessão
     * no formato de um array
     * @param type $var
     * @param type $value 
     */
    public function addValue($var, $value) {
        if (!is_null($this->nome)) {
            if (!isset($_SESSION[$this->nome][$var])) {
                $_SESSION[$this->nome][$var] = array();
            }
            $_SESSION[$this->nome][$var][] = $value;
        } else {
            if (!isset($_SESSION[$var])) {
                $_SESSION[$var] = array();
            }
            $_SESSION[$var][] = $value;
        }
    }

    /**
     * método getValue()
     * retorna uma variável da sessão
     * @param $var = Nome da variável
     */
    function getValue($var) {
        if (!is_null($this->nome)) {
            if (isset($_SESSION[$this->nome][$var])) {
                return $_SESSION[$this->nome][$var];
            } else {
                return false;
            }
        } else {
            if (isset($_SESSION[$var])) {
                return $_SESSION[$var];
            } else {
                return false;
            }
        }
    }

    public function getValues() {
        return $_SESSION;
    }

    /**
     * Método clear
     * Limpa a variável da Session
     * de acordo com o nome passado
     * @param string $var
     */
    function clear($var) {
        if (!is_null($this->nome)) {
            unset($_SESSION[$this->nome][$var]);
        } else {
            unset($_SESSION[$var]);
        }
    }

    /**
     * método freeSession()
     * destrói os dados de uma sessão
     */
    function freeSession() {
        $_SESSION = array();
        session_destroy();
    }

}
