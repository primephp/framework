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
class ArrayObject extends AbstractCollection {

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
     * 
     */
    public function fillKeys(array $keys, $value) {
        $array = array_fill_keys($keys, $value);
    }

}
