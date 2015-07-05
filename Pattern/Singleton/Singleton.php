<?php

namespace Prime\Patttern\Singleton;

/**
 * Descrição da Trait Singleton
 * 
 * Define a carcaça básica para proporcionar que uma classe possa possuir
 * o padrão Singleton
 * @author tom
 */
trait Singleton {

    protected static $instance;

    /**
     * Retorna uma instância única da classe
     * @return type
     */
    final public static function getInstance() {
        return isset(static::$instance) ? static::$instance : static::$instance = new static;
    }

    /**
     * Construtor privado e final para evitar uma nova instanciação da classe
     */
    final private function __construct() {
        $this->init();
    }

    /**
     * Método para inicialização da Classe
     */
    protected function init() {
        
    }

    /**
     * Método mágico wakeup finalizado e privado para evitar a reinicialização
     * da classe
     */
    final private function __wakeup() {
        
    }

    /**
     * Método mágico clone finalizado e privado para evitar o clone do objeto
     */
    final private function __clone() {
        
    }

}
