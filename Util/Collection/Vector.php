<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Util\Collection;

use Prime\core\interfaces\IClonable;
use Prime\io\interfaces\ISerializable;
use Prime\Util\Interfaces\IList;

/**
 * Descrição de Vector
 * A classe Vector implementa uma matriz volume crescente de objetos. 
 * Como uma matriz, que contém componentes que podem ser acessados ​​
 * usando um índice inteiro. No entanto, o tamanho de um vector pode aumentar 
 * .ou diminuir, conforme necessário para acomodar a adição e remoção de itens 
 * depois do vector foi criado. 
 * @author tom
 */
class Vector extends AbstractList implements IList, IClonable, ISerializable {

    public function getClone() {
        
    }

    public function serialize() {
        
    }

    public function subList($fromIndex, $toIndex) {
        
    }

    /**
     * Aumenta a capacidade deste vector, se necessário, para assegurar que ele 
     * pode conter, pelo menos, o número de componentes especificados pelo 
     * argumento de capacidade mínima. 
     * @param array $anArray
     */
    public function copyInto(array $anArray) {
        
    }

    /**
     * Recorta a capacidade deste vetor para ser o tamanho atual do vetor. Se a 
     * capacidade deste vector é maior do que a sua dimensão actual, então a 
     * capacidade é alterada para corresponder ao tamanho, substituindo o seu 
     * conjunto de dados interno, mantido no campo elementData, com um menor. 
     * Um aplicativo pode usar esta operação para minimizar o armazenamento de um vetor.
     */
    public function trimToSize() {
        
    }

    /**
     * Aumenta a capacidade deste vector, se necessário, para assegurar que ele 
     * pode conter, pelo menos, o número de componentes especificados pelo 
     * argumento de capacidade mínima. 
     * @param int $minCapacity
     */
    public function ensureCapacity($minCapacity) {
        
    }

    /**
     * Define o tamanho desse vetor. Se o novo tamanho é maior do que o tamanho 
     * actual, novos itens nulos são adicionados ao final do vector. Se o novo 
     * tamanho é menos do que o tamanho actual, todos os componentes no índice 
     * newSize e maior são descartadas.
     * @param int $newSize
     */
    public function setSize($newSize) {
        
    }

    /**
     * Retorna a capacidade atual desse vetor.
     * @return int A capacidade atual do vetor
     */
    public function capacity() {
        
    }

    /**
     * Retorna uma enumeração das componentes deste vetor. O objeto Enumeration 
     * voltou irá gerar todos os itens deste vetor. O primeiro ponto é gerado o 
     * item no índice 0, então o item no índice 1, e assim por diante.
     */
    public function elements() {
        
    }

    public function elementAt($index) {
        
    }

    public function firstElement() {
        
    }

    public function lastElement() {
        
    }

    public function setElementAt($e, $index) {
        
    }

    /**
     * Exclui o componente no índice especificado. Cada componente, neste 
     * vector, com um maior índice de ou igual ao índice especificado é 
     * deslocado para baixo para ter um índice de uma menor do que o valor que 
     * tinha anteriormente. O tamanho deste vetor é diminuído em 1. 
     * @param int $index
     * @return boolean
     */
    public function removeElementAt($index) {
        return $this->removeIn($index);
    }

    /**
     * Insere o objeto especificado como um componente neste vetor no índice 
     * especificado. Cada componente, neste vector, com um maior índice de ou 
     * igual ao índice especificado é deslocado para cima para ter um índice 
     * maior do que o valor que tinha anteriormente. 
     * @param mixed $e
     * @param int $index
     */
    public function intertElementAt($e, $index) {
        return $this->addIn($index, $e);
    }

    /**
     * Adiciona o componente especificado para o fim deste vector, aumentando 
     * a sua dimensão por um. A capacidade deste vector é aumentada se a sua 
     * dimensão se torna maior do que a sua capacidade. 
     * @param boolean $e Returna FALSE caso o elemento já esteja adicionado e não 
     * aceite duplicatas e TRUE caso tenha sido adicionado com sucesso.
     */
    public function addElement($e) {
        return $this->add($e);
    }

    /**
     * Remove o primeiro (menor indexados) ocorrência do argumento deste vetor. 
     * Se o objeto for encontrado neste vetor, cada componente do vetor com um
     *  índice maior ou igual ao índice do objeto é deslocado para baixo para 
     * ter um índice de um menor do que o valor que tinha antes. 
     * @param boolean $e
     */
    public function removeElement($e) {
        return $this->remove($e);
    }

    /**
     * Remove todos os componentes deste vetor e define o seu tamanho para zero. 
     * @return type
     */
    public function removeAllElements() {
        return $this->clear();
    }

}
