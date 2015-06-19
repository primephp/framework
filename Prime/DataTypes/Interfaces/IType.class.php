<?php

namespace Prime\DataTypes\Interfaces;

/**
 * Descrição da Interface IType
 * @name IType
 * @package Prime\DataTypes\Interfaces
 * @version 1.0
 * @author tom
 * @since 22/10/2011
 * @access public
 */
interface IType {

    const VALUE = 'value';

    public function setValue($value);

    public function getValue();
}
