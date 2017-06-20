<?php

namespace Prime\Util\Interfaces;

/**
 * Uma coleção linear que suporta elemento de inserção e remoção em ambas as 
 * extremidades. O nome deque é a abreviação de "fila dupla terminou" e é 
 * geralmente pronunciado "deck". A maioria das implementações deque colocar 
 * nenhum limite fixo para o número de elementos que podem conter, mas esta 
 * interface suporta deques com restrição de capacidade, bem como aqueles que 
 * não têm limite de tamanho fixo. 
 * @dateCreate 17/06/2014
 * @author tom
 */
interface IDeque extends IQueue {

    /**
     * Insere o elemento especificado an fila
     * @param mixed $e
     * @return boolean 
     */
    public function add($e);

    /**
     * Insere o elemento especificado na frente da fila
     * @param mixed $e
     * @return void
     */
    public function addFirst($e);

    /**
     * Insere o elemento especificado no final da fila
     * @param type $e
     * @return void
     */
    public function addLast($e);

    /**
     * Retorna <b>true</b> se a fila contém o elemento especificado
     * @param mixed $o
     */
    public function contains($o);

    /**
     * Retorna um iterador sobre os elementos desta Deque em ordem sequencial
     * inversa
     * @return IIterator Iterador para os elementos da fila
     */
    public function descendingIterator();

    /**
     * Retorna, porém não remove, o primeiro elemento desta Deque
     * @return mixed
     */
    public function element();

    /**
     * Retorna, porém não remove, o primeiro elemento da Deque
     * @return mixed
     */
    public function getFirst();

    /**
     * Retorna, porém não remove, o último elemento da Deque
     * @return mixed
     */
    public function getLast();

    /**
     * Retorna um iterador sobre os elementos neste deque na sequência correta.
     * @return IIterator
     */
    public function iterator();

    /**
     * Insere o elemento especificado na fila representado por este Deque 
     * (em outras palavras, no final da fila) 
     * @param mixed $e O elemento a ser adicionado
     * @return boolean Retorna TRUE caso seja adicionado com sucesso
     */
    public function offer($e);

    /**
     * Insere o elemento especificado na parte da frente desta Deque
     * @param mixed $e O elemento a ser adicionado
     * @return boolean Retorna TRUE caso seja adicionado com sucesso
     */
    public function offerFirst($e);

    /**
     * Insere o elemento especificado no final desta Deque
     * @param mixed $e O elemento a ser adicionado
     * @return boolean Retorna TRUE caso seja adicionado com sucesso
     */
    public function offerLast($e);

    /**
     * Recupera, mas não remove, o primeiro elemento da fila representada por 
     * essa Deque, ou retorna null se ese Deque estiver vazio
     * @return mixed|null
     */
    public function peek();

    /**
     * Recupera, mas não remove, o primeiro elemento deste deque, ou retorna 
     * null se este deque está vazio.
     * @return mixed|null
     */
    public function peekFirst();

    /**
     * Recupera, mas não remove, o último elemento deste deque, ou retorna 
     * null se este deque está vazio.
     * @return mixed|null
     */
    public function peekLast();

    /**
     * Recupera e remove, o primeiro elemento deste deque, ou retorna 
     * null se este deque está vazio.
     * @return mixed|null
     */
    public function poll();

    /**
     * Recupera e remove, o primeiro elemento deste deque, ou retorna 
     * null se este deque está vazio.
     * @return mixed|null
     */
    public function pollFirst();

    /**
     * Recupera e remove, o último elemento deste deque, ou retorna 
     * null se este deque está vazio.
     * @return mixed|null
     */
    public function pollLast();

    /**
     * Remove um elemento da pilha representada por este deque.
     * @return mixed|NULL
     */
    public function pop();

    /**
     * Coloca um elemento na pilha representado por este deque, em outras palavras
     * no início desta Deque
     * @param mixed $e
     * @return boolean 
     */
    public function push($e);

    /**
     * Remove a primeira ocorrência do elemento especificado a partir deste deque.
     * @param mixed $o
     */
    public function remove($o = NULL);

    /**
     * Recupera e remove o primeiro elemento deste deque.
     * @return mixed
     */
    public function removeFirst();

    /**
     * Remove a primeira ocorrência do elemento especificado a partir deste deque.
     * @param mixed $o
     * @return boolean
     */
    public function removeFirstOccurrence($o);

    /**
     * Recupera e remove o última elemento deste deque.
     * @return mixed
     */
    public function removeLast();

    /**
     * Remove a última ocorrência do elemento especificado a partir deste deque.
     * @param mixed $o
     * @return boolean
     */
    public function removeLasttOccurrence($o);

    /**
     * Retorna o número de elementos desta Deque
     * @return int
     */
    public function size();
}
