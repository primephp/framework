<?php

namespace Prime\Pattern\Singleton;

/**
 * Descrição da Trait Singleton
 * 
 * Define a carcaça básica para proporcionar que uma classe possa possuir
 * o padrão Singleton
 * @author tom
 */
trait SingletonTrait
{

    static $instance = null;

    /**
     * Retorna uma instância única de uma classe.
     *
     * @staticvar Singleton $instance A instância única dessa classe.
     *
     * @return __CLASS__ A Instância única.
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Construtor do tipo protegido previne que uma nova instância da
     * Classe seja criada através do operador `new` de fora dessa classe.
     */
    protected function __construct()
    {
        
    }

    /**
     * Método clone do tipo privado previne a clonagem dessa instância
     * da classe
     *
     * @return void
     */
    private function __clone()
    {
        
    }

    /**
     * Método unserialize do tipo privado para prevenir a desserialização
     * da instância dessa classe.
     *
     * @return void
     */
    private function __wakeup()
    {
        
    }

}
