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
class ArrayList extends AbstractList implements IList, IClonable, ISerializable {

    /**
     * Serializa o objeto ArrayList
     * 
     * @return string contendo o byte-stream representando o objeto ArrayList
     */
    public function serialize() {
        return serialize($this->toArray());
    }

    public function merge($array) {
        $this->collection = array_merge($this->collection, $array);
    }

}
