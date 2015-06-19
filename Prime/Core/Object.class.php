<?php

namespace Prime\Core;

use stdClass;

/**
 * Descrição da Classe Object
 * @name Object
 * @package Prime\Core
 * @author TomSailor
 * @since 03/08/2011
 */
class Object extends stdClass {

    /**
     * Armazena todos os dados do Objeto
     * @var array
     * @access protegido
     */
    protected $data;

    /**
     * permite que uma classe decida como se comportar 
     * quando for convertida para uma string. 
     * @return string 
     */
    public function __toString() {
        return get_class($this);
    }

    /**
     * Método mágico __set
     * é executado ao se escrever dados para membros inacessíveis. 
     * @param string $name
     * @param mixed $value 
     */
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    /**
     * 
     * @param type $name 
     */
    public function __unset($name) {
        unset($this->data[$name]);
    }

    /**
     * Método Mágico __get
     * é utilizados para ler dados de membros inacessíveis. 
     * @param string $name
     * @return mixed 
     */
    public function __get($name) {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        } else {
            return false;
        }
    }

    public function __destruct() {
        unset($this->data);
    }

    /**
     * O método __invoke é chamado quando um script
     *  tenta chamar um objeto como uma função. 
     */
    public function __invoke() {
        ;
    }

    /**
     * Retorna o tipo do objeto atual
     * @return str
     */
    public function getType() {
        return get_class($this);
    }

    /**
     * Retorna um código hash do tipo MD5 representando o objeto atual
     * @return str
     */
    public function getHashCode() {
        return hash('md5', $this);
    }

    /**
     * Retorna um clone do objeto atual
     * @return unknown
     */
    public function getClone() {
        return clone $this;
    }

}

