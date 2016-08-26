<?php

namespace Prime\Model\SQL;

/**
 * @name SQLGroupBy
 * @package Prime\Model\SQL
 * @since 21/01/2012
 * @author TomSailor
 */
final class SQLGroupBy extends SQLExpression {

    private static $struct = NULL;

    /**
     *
     * @param array $column     
     */
    public function __construct($column = NULL) {
        self::$struct = [];
        if (is_array($column) || is_string($column)) {
            $this->add($column);
        }
    }

    /**
     * Pode-se passar uma string como parâmetro ou um array
     * com nomes válidos de campos;
     * String que representam números não serão usados.
     * @param {string|array} $column
     */
    public function add($column = []) {
        if (is_array($column)) {
            self::$struct = array_merge($column, self::$struct);
        } elseif (is_string($column) && !is_numeric($column)) {
            self::$struct[] = $column;
        }
    }

    public function dump() {
        if (count(self::$struct)) {
            return implode(", ", self::$struct);
        }
        return " ";
    }

}
