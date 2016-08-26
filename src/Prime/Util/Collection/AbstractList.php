<?php

/*
 * Copyright (C) 2014 tom This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Prime\Util\Collection;

use Prime\Core\Exceptions\IllegalArgumentException;
use Prime\Core\Exceptions\IndexOutOfBoundsException;
use Prime\Core\TObject;
use Prime\Util\Interfaces\IList;
use UnexpectedValueException;

/**
 * Descrição de AbstractList
 * Essa classe fornece uma implementação do esqueleto da interface IList para 
 * minimizar o esforço necessário para implementar essa interface apoiada por 
 * um "acesso aleatório" dos dados armazenados (como um array). Que permite a 
 * inserção de elementos repetidos ou iguais. Para acessar os 
 * dados sequenciais (como uma lista ligada), AbstractSequentialList deve ser 
 * usado de preferência a esta classe.
 * @author tom
 */
abstract class AbstractList extends AbstractCollection implements IList {

    /**
     * O número de vezes que esta lista foi estruturalmente modificado.
     * @var int
     */
    protected $modCount = 0;

    /**
     * Insere o elemento especificado na posição especificada nesta lista. 
     * Desloca o elemento atualmente naquela posição (se houver) e quaisquer 
     * elementos subsequentes para a direita (adiciona um aos seus índices).
     * @param int $index
     * @param mixed $element
     */
    public function addIn($index, $element) {
        if (!is_int($index)) {
            throw new UnexpectedValueException('Índice informado não é um INTEIRO');
        }
        if ($index > $this->size() || $index < 0) {
            throw new IndexOutOfBoundsException('Indice fora do intervalo');
        }
        if (!is_object($element)) {
            $element = TObject::create($element);
        }
        $this->checkType($element);
        if (isset($this->collection[$index])) {
            array_splice($this->collection, $index, 0, array($element));
        } else {
            $this->collection [$index] = $element;
        }
        $this->modCount++;
    }

    /**
     * Remove o elemetno na posição especificada e descola quaisquer elementos
     * subsequentes para a esquerda (subtraindo um de seus índices). Retorna
     * o elementos que foi removido da lista
     * @param int $index O índice do elemento a ser removido
     * @return mixed O elemento previamente na posição especificada
     * @throws UnexpectedValueException
     * @throws IndexOutOfBoundsException
     */
    public function removeIn($index) {
        if (!is_int($index)) {
            throw new UnexpectedValueException('Índice informado não é um INTEIRO');
        }
        if (isset($this->collection [$index])) {
            $e = $this->collection [$index];
            unset($this->collection[$index]);
            $this->collection = array_values($this->collection);
            $this->modCount++;
            return $e;
        } else {
            throw new IndexOutOfBoundsException('Indice fora do range de elementos');
        }
    }

    /**
     * Retorna o elemento na posição especificada na lista.
     * @param int $index
     * @return mixed|NULL
     */
    public function getIn($index) {
        if (is_null($index)) {
            return NULL;
        }
        if (!is_int($index)) {
            throw new UnexpectedValueException('Índice informado não é um INTEIRO');
        }
        if (isset($this->collection [$index])) {
            return $this->collection [$index];
        }
        return NULL;
    }

    /**
     * Retorna o índice da primeira ocorrência do elemento especificado na 
     * lista, ou FALSE se esta lista não contém o elemento.
     * @param mixed $o
     * @return int
     */
    public function indexOf($o) {
        return array_search($o, $this->collection);
    }

    /**
     * Retorna o índice da última ocorrência do elemento especificado na lista, ou 
     * FALSE se esta lista não contém o elemento.
     * @param mixed $o
     * @return int
     */
    public function lastIndexOf($o) {
        $array = array_reverse($this->collection, TRUE);
        return array_search($o, $array);
    }

    /**
     * Retorna o índice do primeiro elemento da lista
     * @return int
     */
    public function getFirstIndex() {
        reset($this->collection);
        return key($this->collection);
    }

    /**
     * Retorna o índice do último elemento da lista
     * @return int
     */
    public function getLastIndex() {
        end($this->collection);
        return key($this->collection);
    }

    /**
     * Remove o item especificado se o mesmo contém na lista 
     * @param mixed $o
     */
    public function removeObject($o) {
        $index = $this->indexOf($o);
        if ($index !== FALSE) {
            $this->modCount++;
            unset($this->collection [$index]);
        }
    }

    /**
     * Remove da lista de todos os elementos cujo índice está entre fromIndex, 
     * inclusive, e toIndex, exclusivo. Desloca os elementos seguintes para a 
     * esquerda (reduz o seu índice). Esta chamada encurta a lista 
     * (toIndex - fromIndex) elementos
     * @param int $fromIndex
     * @param int $toIndex
     */
    public function removeRange($fromIndex, $toIndex) {
        if (!is_int($fromIndex)) {
            throw UnexpectedValueException('Índice inicial informado não é um INTEIRO');
        }
        if (!is_int($toIndex)) {
            throw UnexpectedValueException('Índice final informado não é um INTEIRO');
        }
        for ($index = $fromIndex; $index < $toIndex; $index++) {
            if ($this->removeIn($index)) {
                $this->modCount++;
            }
        }
    }

    /**
     * Substitui o elemento na posição especificada na lista com o elemento 
     * especificado (operação opcional).
     * @param int $index
     * @param mixed $element
     */
    public function set($index, $element) {
        $this->checkIndex($index);
        $this->checkType($element);
        $this->collection [$index] = $element;
        $this->modCount++;
    }

    /**
     * Retorna uma visão da parte desta lista entre o fromIndex especificada, 
     * inclusive, e toIndex, exclusivo.
     * @param int $fromIndex Ponto Inicial da subList
     * @param int $toIndex Ponto final da sublist
     * @return AbstractList
     * @throws IndexOutOfBoundsException
     * @throws IllegalArgumentException
     */
    public function subList($fromIndex, $toIndex) {
        end($this->collection);
        $lastIndex = key($this->collection);

        var_dump(array(
            $fromIndex,
            $toIndex));
        if ($fromIndex < 0 || $toIndex > $lastIndex) {
            throw new IndexOutOfBoundsException('Indices informados foram do '
            . 'intervalo da lista');
        }
        if ($fromIndex > $toIndex) {
            throw new IllegalArgumentException('Indices '
            . 'informados estao fora de ordem');
        }
        $class = get_called_class();
        $subList = new $class;
        $subList->setTypeCast($this->getTypeCast());
        /* @var $subList AbstractList */
        for ($index = $fromIndex; $index <= $toIndex; $index++) {
            if (isset($this->collection[$index])) {
                $subList->add($this->collection[$index]);
            }
        }
        return $subList;
    }

    /**
     * Retorn o Iterado para os elementos da lista
     * @return ListIterator
     */
    public function getIterator() {
        return new ListIterator($this);
    }

    /**
     * Verifica se o index é do tipo inteiro
     * @param int $i O índice a ser verificado
     * @return boolean Retorna true caso seja um índice válido
     * @throws IndexOutOfBoundsException Lança excessão caso o índice seja menor
     * que zero ou maior que o tamanho da lista
     */
    protected function checkIndex($i) {
        if (!is_int($i)) {
            return FALSE;
        }
        if ($i > $this->size() || $i < 0) {
            throw new IndexOutOfBoundsException('Indice fora do intervalor');
        }
        return TRUE;
    }

}
