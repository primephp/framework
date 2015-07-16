<?php

namespace Prime\Model\SQL;

/**
 * classe SQLCriteria
 * @package Prime\Model\SQL
 * Esta classe provê uma interface utilizada para definição de critérios
 */
class SQLCriteria extends SQLExpression {

    const ORDER_BY = 'order';
    const GROUP_BY = 'group';
    const LIMIT = 'limit';
    const OFFSET = 'offset';

    private $expressions; // armazena a lista de expressões
    private $operators;     // armazena a lista de operadores
    private $properties;    // propriedades do critério

    /**
     * Método Construtor
     */

    function __construct() {
        $this->reset();
    }

    public function reset() {
        $this->expressions = array();
        $this->operators = array();
        $this->properties = array(self::GROUP_BY => NULL, self::LIMIT => NULL, self::OFFSET => NULL, self::ORDER_BY => NULL);
    }

    /**
     * método add()
     * adiciona uma expressão ao critério
     * @param $expression = expressão (objeto TExpression)
     * @param $operator     = operador lógico de comparação
     */
    public function add(SQLExpression $expression, $operator = self::AND_OPERATOR) {
        // na primeira vez, não precisamos de operador lógico para concatenar
        if (empty($this->expressions)) {
            $operator = NULL;
        }

        // agrega o resultado da expressão à lista de expressões
        $this->expressions[] = $expression;
        $this->operators[] = $operator;
    }

    /**
     * método dump()
     * retorna a expressão final
     */
    public function dump() {
        // concatena a lista de expressões
        if (is_array($this->expressions)) {
            if (count($this->expressions) > 0) {
                $result = '';
                foreach ($this->expressions as $i => $expression) {
                    $operator = $this->operators[$i];
                    // concatena o operador com a respectiva expressão
                    $result .= $operator . $expression->dump() . ' ';
                }
                $result = trim($result);
                return "({$result})";
            }
        }
    }

    /**
     * método setProperty()
     * define o valor de uma propriedade
     * @param $property = propriedade
     * @param $value      = valor
     */
    public function setProperty($property, $value) {
        if (isset($value)) {
            $this->properties[$property] = $value;
        } else {
            $this->properties[$property] = NULL;
        }
    }

    /**
     * método getProperty()
     * retorna o valor de uma propriedade
     * @param $property = propriedade
     */
    public function getProperty($property) {
        if ($this->properties[$property]) {
            return $this->properties[$property];
        }
    }

}

