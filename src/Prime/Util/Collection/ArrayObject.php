<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Util\Collection;

/**
 * Descrição da Classe ArrayObject
 * @name ArrayObject
 * @package Prime\Util\Collection
 * @author Tom Sailor
 * @create 14/08/2016
 */
class ArrayObject extends AbstractCollection implements \ArrayAccess {

    /**
     * Verifica se uma posição existe ou não
     * @param int $offset
     * @return boolean
     */
    public function offsetExists($offset) {
        return isset($this->collection[$offset]);
    }

    /**
     * Retorna o valor de uma posição específica
     * @param int $offset
     * @return mixed
     */
    public function offsetGet($offset) {
        return isset($this->collection[$offset]) ? $this->collection[$offset] : null;
    }

    /**
     * Atribui um valor a uma posição específica
     * @param type $offset
     * @param type $value
     */
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
        $this->sort();
    }

    /**
     * Remove o valor de uma posição específica
     * @param int $offset
     */
    public function offsetUnset($offset) {
        unset($this->collection[$offset]);
        $this->sort();
    }

    /**
     * Modifica a caixa de todas as chaves
     * @param int $case CASE_UPPER ou CASE_LOWER
     */
    public function changeKeyCase($case) {
        $this->collection = array_change_key_case($this->collection, $case);
    }

    /**
     * Divide a coleção em size pedaços. O último pedaço deve conter menos 
     * elementos que o parâmetro size. 
     * @param int $size O tamanho de cada pedaço
     * @param bool $preserve_keys Quando definido para TRUE, chaves serão preservadas. O padrão é FALSE que reindexará os pedaços numericamente
     * @return array Retorna um array multidimensional numericamente indexado, 
     * iniciando com 0, com cada dimensão contendo size elementos. 
     */
    public function chunk($size, $preserve_keys = false) {
        return array_chunk($this->collection, $size, $preserve_keys);
    }

    /**
     * Adiciona os valores combinando um array de chaves e de valores
     * @param array $keys Array a ser usado como chaves
     * @param array $values Array a ser usado como valores
     */
    public function combine(array $keys, array $values) {
        foreach (array_combine($keys, $values) as $key => $value) {
            $this->collection[$key] = $value;
        }
    }

    /**
     * Conta todos os valores de um array <br>
     * Retorna um array utilizando os valores do parâmetro array como chaves e 
     * suas respectivas frequências em array como valores. 
     * @return array Retorna um array associativo de valores de array como 
     * chaves e suas quantias como valor. 
     */
    public function countValues() {
        return array_count_values($this->collection);
    }

    /**
     * Preence o array nas posições das chaves passadas com o valor passado
     * @param array $keys
     * @param mixed $value
     */
    public function fillKeys(array $keys, $value) {
        $array = array_fill_keys($keys, $value);
        foreach ($array as $key => $value) {
            $this->collection[$key] = $value;
        }
        $this->sort();
    }

    /**
     * Ordena o conteúdo da coleção pelo valor da sua chave;
     */
    protected function sort() {
        ksort($this->collection);
    }

    /**
     * Preenche o arraym com $num elementos com o valor $value e chaves começando
     * a partir de $start
     * @param int $start O primeiro índice do array
     * @param int $num Número de elementos a inserir, devendo ser maior ou igual a zero
     * @param mixed $value Valor a preencer
     */
    public function fill($start, $num, $value) {
        $array = array_fill($start, $num, $value);
        foreach ($array as $key => $value) {
            $this->collection[$key] = $value;
        }
        $this->sort();
    }

    public function flip() {
        
    }

    public function keys() {
        
    }

    public function map(callable $callback) {
        
    }

    public function pad($size, $value) {
        
    }

    public function pop() {
        
    }

    public function push() {
        
    }

    public function rand() {
        
    }

    public function reduce() {
        
    }

    public function replace(array $replace) {
        $this->collection = array_replace_recursive($this->collection, $replace);
    }

    public function reverse($preserveKeys = false) {
        $this->collection = array_reverse($this->collection, $preserveKeys);
        ;
    }

    public function search($value) {
        return array_search($value, $this->collection, true);
    }
    
    
    /**
     * Retira o primeiro elemento do array e o retorna, diminuindo o array em um
     * elemento e movendo todos os outros elemento para trás. Todas as chaves 
     * numéricas alteradas para começar a contar a de 0 (zero), enquanto chaves 
     * string permanecerão inalteradas.
     * @return mixed|null Retorna o valor removido, ou NULL se array for vazio ou não é um array.
     */
    public function shift(){
        return array_shift($this->collection);
    }

}
