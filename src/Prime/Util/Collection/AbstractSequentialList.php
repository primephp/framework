<?php

namespace Prime\Util\Collection;

/**
 * Descrição de AbstractSequentialList
 * Essa classe fornece uma implementação do esqueleto da interface List para 
 * minimizar o esforço necessário para implementar essa interface apoiada por 
 * um "acesso sequencial" armazenamento de dados (como uma lista lincada). 
 * Para os dados de acesso aleatório (tais como uma matriz), AbstractList deve 
 * ser usado de preferência a esta classe.
 * @author tom
 * @createAt 16/08/2016
 */
abstract class AbstractSequentialList extends AbstractList {

    /**
     * Retorna um ListIterator sobre os elementos desta lista (na sequência adequada).
     * @return ListIterator
     */
    public function listIterator() {
        return new ListIterator($this);
    }

}
