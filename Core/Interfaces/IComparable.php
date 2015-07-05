<?php

namespace Prime\core\interfaces;

/**
 * Descrição da Interface IComparable
 * @package Prime\core
 * @dateCreate 28/05/2014
 * @author comforsup-0215
 */
interface IComparable {

    /**
     * Compara esse objeto com o objeto especificado para a ordem. Retorna um 
     * número inteiro negativo, zero, ou um inteiro positivo como este objeto é 
     * menor, igual ou maior do que o objeto especificado. 
     * @param TObject $o O objeto a ser comparado com o presente o objeto
     * @return int Retorna um número interito negativo, zero, ou um inteiro 
     * positivo como este é menor, igual ou maior do que o objeto passado como 
     * parâmetro
     */
    public function compareTo(Object $o);
}
