<?php

/*
 * Copyright (C) 2014 Elton Luiz This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Prime\Util\Collection;

use ArrayObject;
use Prime\Core\TFloat;
use Prime\Core\TInteger;
use Prime\Core\TObject;
use Prime\Core\TString;
use Prime\Util\Interfaces\ICollection;
use UnexpectedValueException;

/**
 * Descrição de AbstractCollection
 * Essa classe fornece uma implementação do esqueleto da interface Coleção,
 * para minimizar o esforço necessário para implementar essa interface.
 *
 * @author Elton Luiz
 * @dateCreate 05JUN2014
 */
abstract class AbstractCollection extends TObject implements ICollection {

    /**
     * Array que armazena os objetos da coleção
     * @var array
     */
    protected $collection = [];

    /**
     * O tipo de objetos que devem ser aceitos, 
     * caso seja mixed, vai aceitar tipos diversos, no caso de tipos "primitivos"
     * serão convertidos ao serem adicionados
     * @var string
     */
    private $typeCast = 'mixed';

    /**
     * Cria uma coleção do tipo passado como parâmetro
     * @param string $typeCast Define o tipo de objeto que deve ser aceito
     * na coleção
     */
    public function __construct($typeCast = 'mixed') {
        $this->setTypeCast($typeCast);
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
     * Adiciona um elemento a coleção no final da coleção
     *
     * @param mixed $e
     *        	O elemento a ser adicionado
     * @return boolean Returna FALSE caso o elemento já esteja adicionado e não aceite
     *         duplicatas e TRUE caso tenha sido adicionado com sucesso.
     * @throws UnexpectedValueException
     * @return int O total de elementos da coleção
     */
    public function add($e) {
        if (
                $this->getTypeCast() == TInteger::class && is_int($e) ||
                $this->getTypeCast() == TFloat::class && is_float($e) ||
                $this->getTypeCast() == TString::class && is_string($e)
        ) {
            $e = TObject::create($e);
        }
        if (!$this->checkType($e)) {
            throw new UnexpectedValueException("'$e' é do tipo (" . gettype($e) . "). Tipo de dados esperado em " . __METHOD__ . " ({$this->getTypeCast()}).");
        }
        return array_push($this->collection, $e);
    }

    /**
     * Verifica se o tipo do elemento passado é o aceito pela coleção
     * @param mixed $e
     * @return boolean Retorna TRUE caso seja um tipo aceito
     */
    protected function checkType($e) {
        if ($this->getTypeCast() == 'mixed') {
            return true;
        }
        if (is_object($e) && is_a($e, $this->getTypeCast())) {
            return true;
        }
        if (!is_object($e)) {
            if (is_bool($e) && ($this->getTypeCast() == 'bool' || $this->getTypeCast() == 'boolean')) {
                return true;
            }
            if (is_int($e) && ($this->getTypeCast() == 'int' || $this->getTypeCast() == 'integer')) {
                return true;
            }
            if (is_float($e) && ($this->getTypeCast() == 'float' || $this->getTypeCast() == 'double')) {
                return true;
            }
            if (is_string($e) && ($this->getTypeCast() == 'string' || $this->getTypeCast() == 'str')) {
                return true;
            }
            if (is_array($e) && $this->getTypeCast() == 'array') {
                return true;
            }
        }
        return false;
    }

    /**
     * Adiciona todos os elementos da coleção passada nesta coleção
     *
     * @param ICollection $collection Coleção de dados que devem ser adicionados
     * na coleção atual.      	
     * @return boolean Retorna TRUE se os objetos foram adicionados
     */
    public function addAll(ICollection $collection) {
        $r = false;
        foreach ($collection as $value) {
            $this->add($value);
            $r = true;
        }
        return $r;
    }

    /**
     * Remove todos os elemenos desta coleção
     */
    public function clear() {
        $this->collection = [];
    }

    /**
     * Retorna TRUE se a coleção contém o referido elemeto
     * @param mixed $o
     * @return boolean
     */
    public function contains($o) {
        if (array_search($o, $this->collection) === false) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Retorna TRUE se esta coleção contem todos os elementos da coleção
     * especificada
     * @param ICollection $collection
     * @return boolean Retorna TRUE caso todos os elementos estejam contidos
     * na coleção
     */
    public function containAll(ICollection $collection) {
        foreach ($collection as $value) {
            if (!$this->contains($value)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Verifica se a Collection está vazia, caso sim retorna TRUE, do contrário
     * retorna FALSE
     *
     * @return boolean
     */
    public function isEmpty() {
        if ($this->size()) {
            return false;
        }
        return true;
    }

    /**
     * Retorna um iterados para os elementos contidos na coleção
     * @return CollectionIterator
     */
    public function iterator() {
        return $this->getIterator();
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
        $index = array_search($o, $this->collection);
        if ($index !== FALSE) {
            unset($this->collection [$index]);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Remove todos os elementos desta coleção, que também estão contidos na 
     * coleção especificada
     * @param ICollection $collection
     * @return boolean Retorna TRUE se a coleção foi alterada
     */
    public function removeAll(ICollection $collection) {
        $r = false;
        foreach ($collection as $element) {
            if ($this->remove($element)) {
                $r = true;
            }
        }
        return $r;
    }

    /**
     * Mantém apenas os elementos nesta coleção que estão contidos na coleção 
     * especificada
     * @param ICollection $collection
     * @return boolean Retorna TRUE se a coleção foi alterada
     */
    public function retainAll(ICollection $collection) {
        $array = array();
        $r = false;
        foreach ($collection as $key => $value) {
            if ($this->contains($value)) {
                $array[$key] = $value;
                $r = true;
            }
        }
        $this->clear();
        foreach ($array as $value) {
            $this->add($value);
        }
        return $r;
    }

    /**
     * Retorna o tamanho da collection
     *
     * @return int
     */
    public function size() {
        return count($this->collection);
    }

    /**
     * Retorna o tamanho da collection
     * @return int
     */
    public function sizeOf() {
        return $this->size();
    }

    /**
     * Retorna um array contendo os elementos da presente Collection
     *
     * @return array
     */
    public function toArray() {
        return $this->collection;
    }

    public function toJson() {
        $r = array();
        foreach ($this as $key => $value) {
            $r[(string) $key] = (string) $value;
        }
        return json_encode($r);
    }

    /**
     * Retorna uma instância de ArrayObject contendo os elementos da presente
     * Collection
     *
     * @return \ArrayObject
     */
    public function toArrayObject() {
        return new ArrayObject($this->collection);
    }

    /**
     * Define o estereotipo dos objetos suportados
     * @param string $typeCast
     */
    protected function setTypeCast($typeCast) {
        if (in_array($typeCast, array('string', 'String', 'STRING'))) {
            $this->typeCast = 'string';
        } else
        if (in_array($typeCast, array('int', 'integer', 'INT', 'INTEGER'))) {
            $this->typeCast = 'integer';
        } else
        if (in_array($typeCast, array('bool', 'boolean', 'BOOL', 'BOOLEAN'))) {
            $this->typeCast = 'boolean';
        } else
        if (in_array($typeCast, array('float', 'FLOAT', 'double', 'DOUBLE'))) {
            $this->typeCast = 'float';
        } else {
            $this->typeCast = $typeCast;
        }
    }

    /**
     * Retorna um CollectionIterator para iteração dos elementos da coleção
     * @return CollectionIterator
     */
    public function getIterator() {
        return new CollectionIterator($this);
    }

    /**
     * Retorna o tipo de objetos que a coleção aceita
     * @return string
     */
    protected function getTypeCast() {
        return $this->typeCast;
    }

    public function __toString() {
        return $this->hashCode();
    }

    public function __debugInfo() {
        return $this->toArray();
    }

}
