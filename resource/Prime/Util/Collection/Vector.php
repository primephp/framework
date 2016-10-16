<?php

namespace Prime\Util\Collection;

use Prime\Core\Interfaces\IClonable;
use Prime\Io\Interfaces\ISerializable;
use Prime\Util\Interfaces\ICollection;
use Prime\Util\Interfaces\IList;

/**
 * A classe Vector implementa uma matriz que aceita strings como índices de seus 
 * elementos. Porém os mesmos podem ser acessados além de seus índices de string 
 * por índices inteiros ordenados por ordem de adição a partir do 0 até o seu 
 * limite
 * @author tom
 * @createAt 19/08/2016
 */
class Vector extends AbstractList implements IList, IClonable, ISerializable {

    /**
     * Armazena a associação do índices inteiros com os índices definidos pelo 
     * usuário
     * @var array
     */
    protected $indexes = [];

    /**
     * Armazena o último índice 
     * @var int
     */
    protected $lastIndex = 0;

    /**
     * Associa o índice definido pelo usuários ao índice inteiro ordenado da 
     * coleção e incrementa o último índice inteiro utilizado
     * @param int $int
     * @param string $index
     */
    protected function associateIndex($int, $index) {
        $this->indexes[$int] = $index;
        $this->lastIndex++;
    }

    /**
     * Retorna o índice definido pelo usuário para o elemento da definida 
     * posição
     * @param int $index A posição do referido elemento armazenado 
     * internamete
     * @return string|NULL A chave do elemento dentro da coleção
     */
    protected function getAssociateIndex($index) {
        if (isset($this->indexes[$index])) {
            return (int)$this->indexes[$index];
        }
        return NULL;
    }

    /**
     * @inherit
     */
    public function add($e) {
        parent::add($e);
        $this->associateIndex($this->lastIndex, (string)$this->lastIndex);
    }

    /**
     * @inherit
     */
    public function addIn($index, $element) {
        parent::addIn($index, $element);
        $this->associateIndex($this->lastIndex, $index);
    }

    /**
     * @inherit
     */
    public function addAll(ICollection $collection) {
        foreach ($collection as $value) {
            $this->add($value);
        }
    }

    /**
     * Retorna o elemento contido no index inteiro especificado
     * @param $index
     * @return mixed|NULL
     */
    public function elementAt($index) {
        if (isset($this->collection[$index])) {
            return $this->collection[$index];
        }
        return NULL;
    }

    /**
     * Retorna o conteúdo da coleção serializado
     * @return string
     */
    public function serialize() {
        return serialize($this->toArray());
    }

    /**
     * Copia os elementos do array para o vetor, incluindo os índices
     * casos o índice existe o elementos o mesmo é substituído
     * @param array $anArray
     */
    public function copyInto(array $anArray) {
        foreach ($anArray as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * Retorn um array contendo todos os elementos do Vector indexados por
     * inteiros
     * @return array
     */
    public function elements() {
        $array = [];
        foreach ($this->toArray() as $element) {
            $array[] = $element;
        }
        return $array;
    }

    /**
     * Retorna o primeiro elemento de Vector
     * @return mixed
     */
    public function firstElement() {
        reset($this->collection);
        return current($this->collection);
    }

    /**
     * Retorna o último elemento de Vector
     * @return mixed
     */
    public function lastElement() {
        end($this->collection);
        return current($this->collection);
    }

    /**
     * Define o elemento para o índice especificado. Descartando se houver o 
     * elemento na referida posição
     * @param $e
     * @param $index
     */
    public function setElementAt($e, $index) {
        $this->set($index, $e);
        $this->associateIndex($this->lastIndex, $index);
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
