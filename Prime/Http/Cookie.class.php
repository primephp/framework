<?php

namespace Prime\Http;

/**
 * Descrição da Classe Cookie
 *
 * @copyright Copyright &copy; 2011, www.eltonluiz@hotmail.com
 * @create 12/04/2011
 * @package Prime\Http
 * @author TomSailor <www.eltonluiz@hotmail.com> 
 */
class Cookie {

    private $name;
    private $value = array();
    private $expire = null;
    private $path = "/";
    private $domain = "";
    private $secure = FALSE;
    private $httponly = FALSE;
    private $isLoad = FALSE;

    public function __construct($name) {
        $this->name = $name;
        if ($this->load()) {
            $this->isLoad = TRUE;
        } else {
            $this->isLoad = FALSE;
        }
    }

    /**
     * Método isLoad()
     * Verifica se foi carregado ou não
     * o cookie
     * @return boolean
     */
    public function isLoad() {
        if ($this->isLoad === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método mágico __set
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value) {
        $this->setValue($name, $value);
    }

    public function __get($name) {
        return $this->getValue($name);
    }

    /**
     * Método setValue
     * Define o valor para um cookie
     * @param string $name Nome do Cookie
     * @param mixed $value Valor
     * @param timestamp $duration
     */
    public function setValue($name, $value) {
        $this->value[$name] = $value;
    }

    /**
     * Método getValue()
     * Pega/Retorna o valor/conteúdo do Cookie
     * @param <type> $name
     * @return mixed
     */
    public function getValue($name) {
        if (isset($this->value[$name])) {
            return $this->value[$name];
        } else {
            return false;
        }
    }

    /**
     * Método clear()
     * Limpa os valores do Cookie
     * @param string $name nome do Cookie
     */
    public function clear($name) {
        unset($this->value[$name]);
    }

    /**
     * Método store()
     * Armazena o Cookie com seus valores
     */
    public function store() {
        setcookie($this->getName(), $this->getValues(), $this->expire, $this->path, $this->domain, $this->secure, $this->httponly);
    }

    /**
     * Método getName
     * Retorna o nome do Cookie
     * @return string
     */
    private function getName() {
        return $this->name;
    }

    /**
     * Método getValues()
     * Pega os valores do Cookie
     * @return mixed
     */
    private function getValues() {
        if (is_array($this->value)) {
            return serialize($this->value);
        } else {
            return $this->value;
        }
    }

    /**
     * Método load
     * Carrega os valores
     * @return array
     */
    private function load() {
        if (isset($_COOKIE[$this->name])) {
            $cookie = unserialize($_COOKIE[$this->name]);
            foreach ($cookie as $key => $value) {
                $this->value[$key] = $value;
            }
            return true;
        } else {
            return false;
        }
    }

    public function freeCookie() {
        $this->expire = time() - 3600;
        $this->store();
    }

    /**
     * Método $setLife()
     * Define o tempo de vida do Cookie.
     * Se não for definido o tempo, é definido o tempo de vida até
     * as 23:59:59 do dia corrente.
     * @param int $timelife tempo de vida em segundos
     */
    public function setLife($timelife = null) {
        if (is_null($timelife)) {
            $hoje = date("Y-m-d");
            $limit = $hoje . " 23:59:59";
            $diferenca = strtotime($limit) - strtotime(date("Y-m-d H:i:s"));
            $this->setTimeLife($diferenca);
        } else {
            $this->setTimeLife($timelife);
        }
    }

    /**
     * Método setTimeLife
     * Define o tempo de vida somando o tempo corrente mais o tempo
     * passado
     * @param <type> $timelife
     */
    private function setTimeLife($timelife) {
        $this->expire = time() + $timelife;
    }

}

