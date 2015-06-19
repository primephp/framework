<?php

namespace Prime\Model\SQL;

use Prime\Model\SQL\SQLExpression;

/**
 * Descrição de SQLBetween
 * @name SQLBetween
 * @package Prime\Model\SQL
 * @version 1.0
 * @since 10/06/2012
 * @access public
 * @author tom
 */
class SQLBetween extends SQLExpression {

    private $field, $initial, $final;

    public function __construct($field, $initial, $final) {
        $this->field = $field;
        $this->initial = $initial;
        $this->final = $final;
    }

    /**
     * método dump()
     * retorna o filtro em forma de expressão
     */
    public function dump() {
        // concatena a expressão
        return "{$this->field} BETWEEN '{$this->initial}' AND '{$this->final}'";
    }

}
