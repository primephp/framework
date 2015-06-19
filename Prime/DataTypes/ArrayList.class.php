<?php

namespace Prime\DataTypes;

use Prime\Core\Object,
    Prime\DataTypes\Interfaces\IListable;

/**
 * @name ArrayList
 * @package Prime\DataTypes
 */
class ArrayList extends Object implements IListable {

    private $hasNext = -1;
    private $assocArray = null;
    private $localIndexer = -1;

    /**
     * Serve para armazenar o objetos que seráo adicionados
     * @access private
     *
     */
    private $collection;
    private $size;

    /**
     * @category Construtor
     * Inicializa a collection com um vetor vazio;
     */
    public function __construct() {
        $this->collection = array();
        $this->assocArray = array();
        $this->size = 0;
    }

    /**
     * Desloca o ponteiro para o inicio da lista
     * @return void
     */
    public function reset() {
        $this->hasNext = -1;
    }

    /**
     * Adiciona um valor ao elemento da sequencia de vetorial
     * do objeto ArrayList
     * @param mixed $value
     * @param string $assoc
     *
     */
    public function add($value = null, $assoc = null) {
        //a fim de evitar a sobrecarga no sistema este
        //metodo so permitirá usar indices associativos
        //ou numericos por vez, a ordem dessas condicionais deve
        //ser considerada. DO NOT TOUCH!
        if (!is_null($assoc) && is_string($assoc)) {
            $this->assocArray["$assoc"] = $this->size;
        }
        if (!is_null($value)) {
            $this->collection[$this->size] = $value;
            $this->size++;
        }
    }

    /**
     *
     * Descrição
     * Este metodo deve receber uma string de busca a fim de remove-la;
     * @param mixed $whatToRemove
     *
     */
    public function remove($whatToRemove = null) {
        //busca por todas as coincidencias e as remove da lista
        if (is_string($whatToRemove)) {
            $position = array_search($whatToRemove, $this->collection);
        } else {
            $position = $whatToRemove;
        }
        array_splice($this->collection, $position, 1);
        $this->size = count($this->collection);
        return $this->size;
    }

    /**
     * @return mixed
     * restaura o valor da elemento na posicao dada
     * @param mixed $whereIs
     */
    public function contentAt($whereIs = null) {
        if (is_int($whereIs) || is_string($whereIs)) {
            $index = (is_int($whereIs)) ? $whereIs : $this->assocArray[$whereIs];
            return $this->collection[$index];
        } else {
            trigger_error("Parâmetro do tipo inválido em " . __CLASS__ . "::" . __METHOD__, E_USER_ERROR);
        }
    }

    /* @return  mixed
     * retorna a primeira ocorrencia do conteudo passado como parâmetro de busca
     */

    public function search($findvalue) {
        if (is_string($findvalue)) {
            $firstPos = array_search($findvalue, $this->collection);
            return $this->collection[$firstPos];
        } else {
            trigger_error("Passagem de parâmetro inválido " . __CLASS__ . "::" . __METHOD__, E_USER_ERROR);
        }
        return -1;
    }

    /**
     * @return boolean
     * Esvazia o array.
     */
    public function cleanArray() {
        $this->collection = array();
        $this->size = 0;
        return true;
    }

    /**
     * Um inteiro informando o tamanho do ArrayList
     * @return int
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * Toda estrutura interna dos dados sendo processado no momento.
     * @return array
     */
    public function getElements() {
        return $this->collection;
    }

    /**
     * Verifica a existência de itens na lista.
     *
     * @return boolean
     */
    public function hasNext() {
        if ($this->hasNext < ($this->size - 1) && $this->size > 0) {
            $this->hasNext++;
            return true;
        }
        return false;
    }

    /**
     * Recupera o valor do elemento na posição futura.
     * Caso não seja localizado dados na posição futura retornará NULL.
     * @return ArrayList
     *
     */
    public function getNext() {
        if ($this->size > 0) {
            return $this->contentAt($this->hasNext);
        }
        return null;
    }

    /**
     * Retorna o último primeiro contido
     * no ArrayList
     *
     * @return ArrayList
     */
    public function getFirst() {
        if ($this->size > 0) {
            $this->hasNext = -1;
            return $this->contentAt($this->hasNext + 1);
        }
        return false;
    }

    /**
     * Retorna o último elemento contido
     * no ArrayList
     *
     * @return Object
     */
    public function getLast() {
        if ($this->size > 0) {
            return $this->contentAt($this->size - 1);
        }
        return null;
    }

    /**
     * Informa a posicao do cursor interno
     *
     * @return integer
     */
    public function getIndex() {
        return $this->hasNext;
    }

    /**
     * Retorna a posicao em atual do do elemto iterado.
     * Ao final o calor será igual ao tamanho total de
     * posicões do ArrayList
     * Isto difere de getIndex que ao final retorna o tamanho do
     * ArrayList -1;
     *
     * @return integer
     */
    public function getPosition() {
        return ($this->hasNext + 1);
    }

}

