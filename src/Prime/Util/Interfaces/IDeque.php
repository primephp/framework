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
interface IDeque extends IQueue
{

    public function addLast($e);

    public function offerLast($e);

    public function removeFirst();

    public function pollFirst();

    public function getFirst();

    public function peekFirst();

    public function addFirst($e);
}
