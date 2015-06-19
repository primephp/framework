<?php

namespace Prime\DataTypes;

/**
 * Description of DataArray
 * @package Prime\DataTypes
 *
 * @author TomSailor
 */
class DataArray {

    private $data = array();

    public function __construct() {
        ;
    }

    /**
     * Adiciona um Elemento no Array
     * @param mixed $value Valor a ser adicionado
     * @param mixed $key chave associativa a ser utilizada
     */
    public function add($value, $key = null) {
        if (is_string($key) && !is_null($key)) {
            $this->data[$key] = $value;
        } else {
            $this->data[] = $value;
        }
    }

    /**
     * Verifica se o valor existe nos dados
     * do Array, existindo retorna a sua chave
     * respectiva
     * @param mixed $value
     * @return mixed 
     */
    public function search($value) {
        $key = array_search($value, $this->data);
        if ($key) {
            return $key;
        } else {
            return false;
        }
    }

    /**
     * Retorna os elemetos do Array
     * @return Array 
     */
    public function getElements() {
        return $this->data;
    }

    /**
     * Verifica se a Chave existe no array
     * @param mixed $key
     * @return mixed 
     */
    public function keyExists($key) {
        if (array_key_exists($key, $this->data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retorna o valor de um elemento do Array
     * de acordo com a chave passa, se não existir a chave respectiva
     * no array retorna false
     * @param mixed $key a chave a ser buscada no array
     * @return mixed $value o valor do índice 
     */
    public function getValue($key) {
        if ($this->keyExists($key)) {
            return $this->data[$key];
        } else {
            return false;
        }
    }

    /**
     * Retorna o total de elementos do array
     * @return integer Total
     */
    public function count() {
        return count($this->data);
    }

    /**
     * Método clean()
     * Limpa todo o array, incluindo chaves e valores
     * @return boolean true se o array foi apagado 
     */
    public function clean() {
        $this->data = array();
        return true;
    }

    /**
     * Remove um Elemento com o valor passado no Array
     * @param string/integer $value Valor a ser removido do array
     * @return integer $total de elemento permanecentes no Array 
     */
    public function remove($value) {
        if (is_string($value)) {
            $position = array_search($value, $this->data);
        } else {
            $position = $value;
        }

        array_slice($this->data, $position, 1);
        return $this->count();
    }

}

