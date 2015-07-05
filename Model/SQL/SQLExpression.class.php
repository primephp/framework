<?php

namespace Prime\Model\SQL;

/**
 * classe SQLExpression
 * @package Prime\Model\SQL
 * classe abstrata para gerenciar expressões
 */
abstract class SQLExpression {

    // operadores lógicos

    const AND_OPERATOR = 'AND ';
    const OR_OPERATOR = 'OR ';
    // operadores de comparação
    const IS_EQUAL = '=';
    const IS_DIFFERENT = '<>';
    const IS_LARGER = '>';
    const IS_LARGER_AND_EQUAL = '>=';
    const IS_LESS = '<';
    const IS_LESS_AND_EQUAL = '<=';
    const IS = 'IS';
    const LIKE = 'LIKE';
    const IN = 'IN';
    const NOT_IN = 'NOT IN';

    // marca método dump como obrigatório
    abstract public function dump();
}