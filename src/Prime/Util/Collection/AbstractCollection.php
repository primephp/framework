<?php

/*
 * Copyright (C) 2014 tom This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Prime\Util\Collection;

use ArrayObject;
use Prime\Core\Object;
use Prime\Util\Interfaces\ICollection;

/**
 * Descrição de AbstractCollection
 * Essa classe fornece uma implementação do esqueleto da interface Coleção,
 * para minimizar o esforço necessário para implementar essa interface.
 *
 * @author tom
 * @dateCreate 05JUN2014
 */
abstract class AbstractCollection implements ICollection {

    protected $_collection = [];

    /**
     * Cria uma coleção a partir de um array passado como parâmetro
     *
     * @param array $array        	
     */
    public function __construct(array $array = NULL) {
        if (!is_null($array)) {
            foreach ($array as $value) {
                $this->add($value);
            }
        }
    }

    /**
     * Retorna um objeto de AbastractCollection, recebendo como parâmetro um
     * objeto que implemente a interface ICollection
     *
     * @param ICollection $collection        	
     */
    public static function ofCollection(ICollection $collection) {
        $class = get_called_class();
        return new $class($collection->toArray());
    }

    /**
     * Adiciona um elemento a coleção
     * Caso a coleção não aceite elementos repetidos, e o mesmo já esteja adicionado
     * returna FALSE
     *
     * @param mixed $e
     *        	O elemento a ser adicionado
     * @return boolean Returna FALSE caso o elemento já esteja adicionado e não aceite
     *         duplicatas e TRUE caso tenha sido adicionado com sucesso.
     */
    public function add($e) {
        if (!is_object($e)) {
            $e = Object::create($e);
        }
        $index = array_search($e, $this->_collection);
        if ($index === FALSE) {
            $this->_collection [] = $e;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Adiciona todos os elementos da coleção passada nesta coleção
     *
     * @param ICollection $collection        	
     * @return boolean Retorna TRUE se os objetos foram adicionados
     */
    public function addAll(ICollection $collection) {
        for ($index = 0; $index < $collection->size(); $index ++) {
            $this->add($collection->iterator());
        }
    }

    public function clear() {
        $this->_collection = [];
    }

    public function contains($o) {
        if (array_search($o, $this->_collection)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     *
     * @param ICollection $collection        	
     */
    public function containAll(ICollection $collection) {
        $iterator = $collection->iterator();

        for ($index = 0; $index < $collection->size(); $index ++) {
            
        }
    }

    /**
     * Verifica se a Collection está vazia, caso sim retorna TRUE, do contrário
     * retorna FALSE
     *
     * @return boolean
     */
    public function isEmpty() {
        if ((boolean) count($this->_collection)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function iterator() {
        ;
    }

    /**
     * Retorna, caso existe, o elemento passado como parâmetro da Collection
     *
     * @param mixed $o
     *        	O elemento que deve ser removido da Collection
     * @return boolean Caso o elemeto passado como parâmetro exista na
     *         Collection, o remove e retorna TRUE, do contrário e retorna FALSE
     */
    public function remove($o) {
        $index = array_search($o, $this->_collection);
        if ($index !== FALSE) {
            unset($this->_collection [$index]);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Retorna todos os elementos contidos na collection passado como parâmetro
     * que existam na presente Collection
     *
     * @param ICollection $collection        	
     */
    public function removeAll(ICollection $collection) {
        ;
    }

    public function retainAll(ICollection $collection) {
        ;
    }

    /**
     * Retorna o tamanho da collection
     *
     * @return int
     */
    public function size() {
        return count($this->_collection);
    }

    /**
     * Retorna um array contendo os elementos da presente Collection
     *
     * @return array
     */
    public function toArray() {
        return $this->_collection;
    }

    /**
     * Retorna uma instância de ArrayList contendo os elementos da presente
     * Collection
     *
     * @return ArrayList
     */
    public function toArrayList() {
        return new ArrayList($this->_collection);
    }

    /**
     * Retorna uma instância de ArrayObject contendo os elementos da presente
     * Collection
     *
     * @return \ArrayObject
     */
    public function toArrayObject() {
        return new ArrayObject($this->_collection);
    }

    /**
     * Verifica se o hashCode da Collection passada como parâmemtro é igual
     * ao do presente objeto.
     *
     * @param ICollection $o        	
     * @return boolean Caso sejam iguais o hashCode retorna TRUE, do contário
     *         retorna FALSE
     */
    public function equals(ICollection $o) {
        if ($this->hashCode() === $o->hashCode()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Retorna o hashCode do presente objeto
     *
     * @return string
     */
    public function hashCode() {
        return hash('md5', $this);
    }

}
