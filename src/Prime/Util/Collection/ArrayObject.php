<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Util\Collection;

use ArrayAccess;
use Countable;

/**
 * Descrição da Classe ArrayObject
 * @name ArrayObject
 * @package Prime\Util\Collection
 * @author Tom Sailor
 * @create 14/08/2016
 */
class ArrayObject extends AbstractCollection implements ArrayAccess, Countable {

    /**
     * Flag para ordenação comparando os itens normalmente (não modifica o tipo)
     */
    const SORT_REGULAR = SORT_REGULAR;

    /**
     * Flag para ordenção comparando os itens numericamente
     */
    const SORT_NUMERIC = SORT_NUMERIC;

    /**
     * Flag para ordenação comparando os itens como string
     */
    const SORT_STRING = SORT_STRING;

    /**
     * Flag para ordenção comparando os itens como strings, utilizando o locale
     * atual. Utiliza o local que poser ser modificado com setlocale()
     */
    const SORT_LOCALE_STRING = SORT_LOCALE_STRING;

    /**
     * Flag para ordenação comparando os itens como string utilizando "ordenação 
     * natural" tipo natsort()
     */
    const SORT_NATURAL = SORT_NATURAL;

    /**
     * Floag para ordenção comparando os itens como string sem considerar maiúsculas e
     * minúsculas
     */
    const SORT_FLAG_CASE = SORT_FLAG_CASE;

    /**
     * Conta o número de elementos do objeto
     * @return int
     */
    public function count() {
        return $this->size();
    }

    /**
     * Cria uma coleção do tipo passado como parâmetro
     * @param string $typeCast Define o tipo de objeto que deve ser aceito
     * na coleção
     * @param array $array Array de dados a ser adicionado ao objeto
     */
    public function __construct($typeCast = 'mixed', array $array = null) {
        parent::__construct($typeCast);
        if (!is_null($array)) {
            $this->addArray($array);
        }
    }

    /**
     * Adiciona um array de dados ao objeto
     * @param array $array Array de dados a ser adicionado ao objeto
     */
    public function addArray(array $array) {
        foreach ($array as $value) {
            $this->add($value);
        }
    }

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
        $this->ksort();
    }

    /**
     * Remove o valor de uma posição específica
     * @param int $offset
     */
    public function offsetUnset($offset) {
        unset($this->collection[$offset]);
        $this->ksort();
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
        $this->ksort();
    }

    /**
     * Ordena o conteúdo da coleção pelo valor da sua chave;
     */
    protected function ksort() {
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
        $this->ksort();
    }

    /**
     * Retorna todas as chaves ou uma parte das chaves do array
     * @return array Retorna um array de todas as chaves em array.
     */
    public function keys() {
        return array_keys($this->collection);
    }

    /**
     * Aplica uma função em todos os elementos do array
     * @param callable $callback Função callback para executar para cada elemento
     * do array
     */
    public function map(callable $callback) {
        $this->collection = array_map($callback, $this->collection);
    }

    /**
     * Expande o array para o comprimento especificado por size com o valor value. 
     * Se $size for positivo então o array é expandido pela direita, se for 
     * negativo, pela esquerda.
     * @param int $size Novo tamanho do array
     * @param mixed $value Valor para preencher se o array é menor que o $size
     */
    public function pad($size, $value) {
        $this->collection = array_pad($this->collection, $size, $value);
    }

    /**
     * Extrai e retorna o último elemento do objeto, diminuindo o objeto em um
     * elemento
     * @return mixed Retorna o último valor do objeto. Se o objeto é vazio, NULL
     * será retornado
     */
    public function pop() {
        return array_pop($this->collection);
    }

    /**
     * 
     * @param mixed Primeiro valor a ser adicionado no final do objeto
     * @param mixed $_values [valores opcionais]
     * @return int Retorno o novo número de elementos do objeto
     */
    public function push($value, ...$_values) {
        array_push($this->collection, $value);
        if ($_values) {
            foreach ($_values as $v) {
                $this->push($v);
            }
        }
        return $this->size();
    }

    /**
     * Escolhe aleatoriamente um elemento do objeto e retorna sua chave.
     * @return int A chave para o elemento aleatório
     */
    public function rand() {
        return array_rand($this->collection);
    }

    /**
     * Escolhe aleatoriamente um elemento do objeto e retorna sua chave.
     * @return int A chave para o elemento aleatório
     */
    public function random() {
        return $this->rand();
    }

    /**
     * Escolhe aleatoriamente um elemento do objeto e o retorna.
     * @return mixed O elemento aleatório escolhido
     */
    public function randomValue() {
        return $this->offsetGet($this->rand());
    }

    /**
     * Substitui os valores do objeto pelos mesmos valores do array $replace. Se
     * a chave do elemento do objeto existir em $replace o seu valor será substituído
     * pelo valor do elemento da mesma chave no array $replace. Se a chave existir
     * em $replace e não no objeto, ela será criada no objeto. Se uma chave só 
     * existir no objeto, ela será deixada como está.
     * @param array $replace O array a partir do qual os lementos será extraídos
     */
    public function replace(array $replace) {
        $this->collection = array_replace_recursive($this->collection, $replace);
    }

    /**
     * Inverte a ordem dos elementos do objeto
     * @param boolean $preserveKeys Se definido para TRUE as chaves serão preservadas
     */
    public function reverse($preserveKeys = false) {
        $this->collection = array_reverse($this->collection, $preserveKeys);
    }

    /**
     * Procura por um valor no objeto e retorna sua chave correspondente, caso
     * seja encontrado
     * @param mixed $value
     * @return int|false Retorna a chave correspondente se foi encontrada, ou 
     * FALSE caso contrário
     */
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
    public function shift() {
        return array_shift($this->collection);
    }

    /**
     * Mistura os elementos do array de forma aleatória;
     */
    public function shuffle() {
        shuffle($this->collection);
    }

    /**
     * Ordena os elementos do objeto. Os elementos serão ordenados do menor para 
     * o maior. Se dois itens são comparados como iguais, sua ordenção no final
     * é indefinida
     * @param int $sort_flags Parâmetro opcional $sort_flags, pode ser usado
     * para modificar o comportamento da ordenação
     * @return type
     */
    public function sort($sort_flags = ArrayObject::SORT_REGULAR) {
        return sort($this->collection, $sort_flags);
    }

}
