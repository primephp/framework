<?php

namespace Prime\Util\Collection;

use Prime\Core\Interfaces\IClonable;
use Prime\Io\Interfaces\SerializableInterface;
use Prime\Util\Interfaces\IList;

/**
 * Descrição da Classe ArrayList
 * ArrayList é uma classe para coleções (collections).
 * Coleção para qualquer tipo de 'coisa',
 * diferente de Java, não necessita que sejam obrigatoriamente objetos.
 * 
 * @package Prime\util
 *          @dateCreate 06/06/2014
 * @author Elton Luiz
 */
class ArrayList extends AbstractList implements IList, IClonable, SerializableInterface
{

    /**
     * Capacidade de elementos do ArrayList
     * @var int
     */
    private $capacity = 10;

    /**
     * Instancia um ArrayList podendo receber como parâmetro o tipo de objetos
     * que aceita, capacidade mínima ou um array de dados a ser inserido
     */
    public function __construct($param = 'mixed')
    {
        if (is_int($param)) {
            $this->ensureCapacity($param);
        } else
        if (is_array($param)) {
            foreach ($param as $value) {
                $this->add($value);
            }
        } else {
            if (is_string($param)) {
                $this->setTypeCast($param);
            }
        }
    }

    /**
     * Reduz a capacidade da instância de ArrayList para o tamanho
     * atual da sua lista de elementos
     * @return void
     */
    public function trimToSize()
    {
        $this->capacity = $this->size();
    }

    /**
     * Aumenta a capacidade deste ArrayList, se necessário, para assegurar
     * que ele contenha no mínimo, o número de elementos especificado
     * pela capacidade mínima
     * @param type $minCapacity
     * @return void
     */
    public function ensureCapacity($minCapacity)
    {
        $this->capacity = $minCapacity;
    }

    /**
     * Serializa o objeto ArrayList
     * 
     * @return string contendo o byte-stream representando o objeto ArrayList
     */
    public function serialize()
    {
        return serialize($this->toArray());
    }

    /**
     * @inheritdoc
     */
    public function add($e)
    {
        $t = parent::add($e);
        $this->ensureCapacity($t);
        return $t;
    }

}
