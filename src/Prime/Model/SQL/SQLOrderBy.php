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

    private $struct = NULL;
    private $order = NULL;

    /**
     *
     * @param array $column
     * @param string $order 
     */
    public function __construct($column = NULL, $order = '') {
        $this->struct = '';
        $this->order = '';
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
    public function add($column = [], $order = '') {
        if (is_array($column)) {
            foreach ($column as $value) {
                $this->add($value, $order);
            }
        } elseif (is_string($column) && !is_numeric($column)) {
            $this->struct[] = $column;
            $this->order[] = $order;
        }
    }

    /**
     * 
     * @inheritDoc
     */
    public function dump() {
        $dump = '';
        $total = count($this->struct);
        for ($index = 0; $index < $total; $index++) {
            $dump .= $this->struct[$index] . ' ' . $this->order[$index];
            if ($index < ($total - 1)) {
                $dump .= ', ';
            }
        }
        return $dump;
    }

}
