<?php

namespace Prime\Util\Collection;

use Prime\Core\Interfaces\IClonable;
use Prime\Io\Interfaces\ISerializable;
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
class ArrayList extends AbstractList implements IList, IClonable, ISerializable
{

    /**
     * Retorna um Clone o objeto ArrayList
     * 
     * @return ArrayList
     */
    public function getClone()
    {
        return clone $this;
    }

    /**
     * Serializa o objeto ArrayList
     * 
     * @return string contendo o byte-stream representando o objeto ArrayList
     */
    public function serialize()
    {
        return serialize($this);
    }

    public function subList($fromIndex, $toIndex)
    {
        // user iterator para iterar e criar um novo arrayList através
        // dos parametros passados
    }

    public function merge()
    {
        array_merge($array1, $_);
    }

}
