<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Util\Collection;

use Prime\Util\Interfaces\ICollection;
use Prime\Util\Interfaces\ISet;

/**
 * Descrição da Classe AbstractSet
 * Implementa o esquele da interface ISet de forma que não permite a inserção
 * de elementos repetidos na coleção
 * @name AbstractSet
 * @package Prime\Util\Collection
 * @author Tom Sailor
 * @create 14/08/2016
 */
class AbstractSet extends AbstractCollection implements ISet {

    /**
     * Adiciona o elemento na coleção caso o mesmo não esteja já contido na 
     * mesma
     * @param mixed $e
     * @return boolean Retorna TRUE se o elemento foi adicionado e FALSE
     * caso o elemetno já esteja contido na coleção
     */
    public function add($e) {
        if (!$this->contains($e)) {
            parent::add($e);
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Adiciona os elementos contidos no parâmetro que não já estejam na referida
     * coleção
     * @param ICollection $collection
     */
    public function addAll(ICollection $collection) {
        $iterator = $collection->iterator();
        while ($iterator->hasNext()) {
            $i = $iterator->next();
            $this->add($i);
        }
    }

    public function iterator() {
        ;
    }

}
