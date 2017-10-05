<?php

namespace Prime\Core;

use stdClass;
use UnexpectedValueException;

/**
 * A classe TObject foi criada para ser a raiz da hierarquia de classes do
 * PrimePHP Framework.
 * @name TObject
 * @package Prime\core
 * @author Elton Luiz
 * @since 03/08/2011
 */
class TObject extends stdClass
{

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
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Método mágico __set
     * é executado ao se escrever dados para membros inacessíveis. 
     * @param string $name
     * @param mixed $value 
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Método mágico __unset é executado ao 
     * @param type $name 
     */
    public function __unset($name)
    {
        unset($this->data[$name]);
    }

    /**
     * Método Mágico __get
     * é utilizados para ler dados de membros inacessíveis. 
     * @param string $name
     * @return mixed 
     */
    public function __get($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        } else {
            return false;
        }
    }

    /**
     * O método __destruct remove todo conteúdo do atributo $data do objeto, para remover
     * o uso da memória
     */
    public function __destruct()
    {
        unset($this->data);
    }

    /**
     * O método __invoke é chamado quando um script
     * tenta chamar um objeto como uma função. 
     */
    public function __invoke()
    {
        return $this->toString();
    }

    /**
     * Retorna o tipo do objeto atual
     * @return string O nome da classe do objeto instanciado
     */
    public function getType()
    {
        return get_class($this);
    }

    /**
     * Retorna o nome da classe do objeto
     * @return string O nome da classe do objeto instanciado
     */
    public function getClass()
    {
        return $this->getType();
    }

    /**
     * Retorna um código hash do tipo SHA256 da serialização do presente
     * objeto
     * @return str Código Hash do presente objeto
     */
    public function hashCode()
    {
        return hash('SHA256', serialize($this));
    }

    /**
     * Retorna um clone do objeto atual
     * @return $this
     */
    public function getClone()
    {
        return clone $this;
    }

    /**
     * Cria um objeto para os principais tipos escalares, através do
     * parâmetro passado
     * @param string|integer|float|boolean $value
     * @return TBoolean|TInteger|TString|TFloat
     * @throws UnexpectedValueException
     */
    public static function create($value)
    {
        if (is_float($value)) {
            return new TFloat($value);
        } else
        if (is_integer($value)) {
            return new TInteger($value);
        } else
        if (is_bool($value)) {
            return new TBoolean($value);
        } else
        if (is_string($value)) {
            return new TString($value);
        } else {
            throw new UnexpectedValueException("$value nao e do tipo string, integer, boolean ou float");
        }
    }

    /**
     * Retorna o nome da classe do objeto
     * @return string O nome da classe do objeto instanciado
     */
    public function toString()
    {
        return $this->getType();
    }

    /**
     * Verifica se os objetos são iguais
     * @param TObject $o
     * @return boolean
     */
    public function equals(TObject $o)
    {
        if ($this->hashCode() == $o->hashCode()) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Verifica se o objeto está vazio
     * @return boolean
     */
    public function isEmpty()
    {
        if (count($this->data)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
