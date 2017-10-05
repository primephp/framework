<?php

namespace Prime\Util\Interfaces;

/**
 * 
 * @author Elton Luiz
 * @date 28/05/2014
 */
interface IEnumeration
{

    /**
     * Testa se esta enumeração contaim mais elementos
     * @return Boolean true se e somente se este objeto enumeração contém, 
     * pelo menos, mais um elemento para fornecer; false caso contrário.
     */
    public function hasMoreElements();

    /**
     * Retorna o próximo elemento desta enumeração se este objeto de enumeração
     * tem mais elementos para prover
     * @return mixed o próximo elemento desta enumeração
     */
    public function nextElement();
}
