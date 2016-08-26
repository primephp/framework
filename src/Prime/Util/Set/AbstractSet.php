<?php

namespace Prime\Util\Set;

use Prime\Util\Collection\AbstractCollection;
use Prime\Util\Interfaces\ISet;

/**
 * Descrição da Classe AbstractSet<br>
 * A implementação se ISet(interface de conjuntos) tem uma implementação
 * idêntica a uma coleção ICollection, exceto ao fato de não permitir a 
 * adição de elementos idênticos
 * @name AbstractSet
 * @package Prime\Util\Set
 * @author Tom Sailor
 * @create 26/08/2016
 */
abstract class AbstractSet extends AbstractCollection implements ISet {

    /**
     * Retorna o número de elementos do conjunto
     * @return int O total de elementos contidos
     */
    public function size() {
        return parent::size();
    }

    /**
     * Retorna TRUE se este conjuntos contém elementos
     * @return boolean TRUE se este conjunto contém elementos
     */
    public function isEmpty() {
        return parent::isEmpty();
    }

    /**
     * Verifica se o elementos está contido no conjunto
     * @param mixed $o O elemento cuja presença será verificada no conjunto
     * @return boolean TRUE se este conjunto contém o elemento espeficicado
     */
    public function contains($o) {
        return parent::contains($o);
    }

    /**
     * Retorna um iterador para os elementos deste conjuntos
     * @return IIterator Um iterador para os elementos deste conjunto
     */
    public function iterator() {
        return parent::iterator();
    }

    /**
     * Retorna um array contendo todos os elementos deste conjunto
     * @return array Um array contendo todos os elementos deste conjunto
     */
    public function toArray() {
        return parent::toArray();
    }

    /**
     * Adiciona o elementos especificado para este conjunto se ele não está 
     * presente
     * @param mixed $e O elemento a ser adicionado no conjunto
     * @return boolean TRUE se o conjunto não contém o elemento especificado
     */
    public function add($e) {
        if (!$this->contains($e)) {
            parent::add($e);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Remove o elemento especificado deste conjunto se ele estiver presente. 
     * @param mixed $o O objeto a ser removido deste conjunto, se presente
     * @return boolean TRUE se este conjuntos continha o elemento especificado
     */
    public function remove($o) {
        return parent::remove($o);
    }

    /**
     * Retorna TRUE se este conjunto contém todos os elementos da coleção 
     * especificada.
     * @param ICollection $c Coleção a ser verificada se está contida neste 
     * conjunto
     * @return boolean Retorna TRUE se o conjunto contém todos os elementos da
     * coleção
     */
    public function containsAll(ICollection $c) {
        return parent::containAll($collection);
    }

    /**
     * Adiciona todos os elementos da coleção passada como parâmetro pare este 
     * conjunto se eles não já estarem contidos. Se a coleção especificada 
     * também for um conjunto, o método addAll modificada de forma eficaz esse
     * conjunto de modo que o seu valor seja a união dos dois conjuntos
     * @param ICollection $c Coleção contendo os elementos a serem adicionados
     * no conjunto
     * @return boolean TRUE se este conjunto foi alterado
     */
    public function addAll(ICollection $c) {
        $r = false;
        foreach ($c as $value) {
            if ($this->add($value)) {
                $r = true;
            }
        }
        return $r;
    }

    /**
     * Mantém apenas no conjunto os elementos que estão contidos na referida
     * coleção
     * @param ICollection $c Coleção que contém os elementos
     * que devem ser mantidos
     * @return boolean Retorna TRUE se foi feita alguma alteração no conjunto
     */
    public function retainAll(ICollection $c) {
        return parent::retainAll($c);
    }

    /**
     * Remove todos os elementos do conjunto que estão contidos na referida
     * coleção
     * @param ICollection $c Coleção contendo os elementos que devem ser removidos
     * @return boolean Retorna TRUE se foi feita alguma removeção no conjunto
     */
    public function removeAll(ICollection $c) {
        return parent::removeAll($c);
    }

    /**
     * Remove todos os elementos deste conjunto
     */
    public function clear() {
        return parent::clear();
    }

    /**
     * Compara o objeto passado como parâmetro com o presente conjunto
     * @param mixed $o Retorna true se os objetos são iguais
     */
    public function equals($o) {
        return parent::equals($o);
    }

    /**
     * Retorna o valor do hashcode deste conjunto
     * @return string O valor do hashcode deste conjunto
     */
    public function hashCode() {
        return parent::hashCode();
    }

}
