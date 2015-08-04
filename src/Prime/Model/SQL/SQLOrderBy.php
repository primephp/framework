<?php

namespace Prime\Model\SQL;

/**
 * @name SQLOrderBy
 * @package Prime\Model\SQL
 * @since 21/01/2012
 * @author TomSailor
 */
final class SQLOrderBy extends SQLExpression {

    const DESC_OPERATOR = " desc ";
    const ASC_OPERATOR = " asc ";

    private static $struct = NULL;
    private static $order = "";

    /**
     *
     * @param array $column
     * @param string $order 
     */
    public function __construct($column = NULL, $order = self::ASC_OPERATOR) {
        self::$struct = [];
        if (is_array($column) || is_string($column)) {
            $this->add($column, $order);
        }
    }

    /**
     * Pode-se passar uma string como parâmetro ou um array
     * com nomes válidos de campos;
     * String que representam números não serão usados.
     * @param {string|array} $column
     */
    public function add($column = [], $order = self::ASC_OPERATOR) {
        self::$order = $order;
        if (is_array($column)) {
            self::$struct = array_merge(self::$struct, $column);
        } elseif (is_string($column) && !is_numeric($column)) {
            self::$struct[] = $column;
        }
    }

    public function dump() {
        if (count(self::$struct)) {
            return (implode(", ", self::$struct) . self::$order);
        }
        return "";
    }

}


