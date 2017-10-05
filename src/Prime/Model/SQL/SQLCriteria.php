<?php

namespace Prime\Model\SQL;

/**
 * classe SQLCriteria
 * @package Prime\Model\SQL
 * Esta classe provê uma interface utilizada para definição de critérios
 */
class SQLCriteria extends SQLExpression
{

    private $expressions; // armazena a lista de expressões
    private $operators;     // armazena a lista de operadores
    /**
     * Limite de registros a serem retornados
     * @var int 
     */
    private $limit = NULL;

    /**
     * Quantidades de linhas a serem puladas
     * @var int 
     */
    private $offset = NULL;

    /**
     * Critério de ordenamento da consulta
     * @var string
     */
    private $order = NULL;

    /**
     * Critério de agrupamento da consulta
     * @var string 
     */
    private $group = NULL;

    /**
     * Método Construtor
     */
    function __construct()
    {
        $this->reset();
    }

    /**
     * Resseta os critérios de consulta
     */
    public function reset()
    {
        $this->expressions = [];
        $this->operators = [];
    }

    /**
     * Adiciona um expressão de critério de consulta
     * @param \Prime\Model\SQL\SQLExpression $expression
     * @param string $operator Operador lógico de comparação
     */
    public function add(SQLExpression $expression, $operator = self::AND_OPERATOR)
    {
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
    public function dump()
    {
        $result = '';
        if (count($this->expressions) > 0) {
            foreach ($this->expressions as $i => $expression) {
                $operator = $this->operators[$i];
                // concatena o operador com a respectiva expressão
                $result .= $operator . $expression->dump() . ' ';
            }
            $result = trim($result);
            return "({$result})";
        }
    }

    /**
     * Define os campos para ordenamentos dos registros que serão retornados
     * @param string|SQLOrderBy $field
     * @param string $order ASC ou DESC
     */
    public function setOrderBy($field, $order = '')
    {
        if ($field instanceof SQLOrderBy) {
            $this->order = $field->dump();
        } else {
            $this->order = $field . " " . $order;
        }
    }

    /**
     * Retorna o critério de ordenamentos dos registros a serem retornados
     * @return string
     */
    public function getOrderBy()
    {
        return $this->order;
    }

    /**
     * Define os critérios para o agrupamento dos registros a serem retornados
     * @param string|SQLGroupBy $fields
     */
    public function setGroupBy($fields)
    {
        if ($fields instanceof SQLGroupBy) {
            $this->group = $fields->dump();
        } else {
            $this->group = $fields;
        }
    }

    /**
     * Retorna os critérios de agrupamento dos registros a serem retornados
     * @return string
     */
    public function getGroupBy()
    {
        return $this->group;
    }

    /**
     * Define o limit de registros a serem retornados
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * Retorna o limite de registros a serem retornados 
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Define a quantidade de linhas que devem ser puladas antes
     * de começar a retornar os registros
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * Retorna a quantidade de linha que devem ser puladas antes
     * de começar a retorna os registros
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

}
