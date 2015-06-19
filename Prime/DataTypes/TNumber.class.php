<?php

namespace Prime\DataTypes;
/**
 * @package Prime\DataTypes
 */
interface TNumber {

    /**
     * @return number
     * Deve o valor de cada Objeto para o seu respectivo tipo	 * 
     *
     */
    public function valueOf();

    public function equals(Object $obj);

    public function __toString();
}

