<?php

namespace Prime\Model\SQL;

/**
 * classe SQLStatement
 * @package Prime\Model\SQL
 * Esta classe provê os métodos em comum entre todas
 * instruções SQL (SELECT, INSERT, DELETE e UPDATE)
 */
abstract class SQLStatement
{

    protected $sql;       // armazena a instrução SQL
    /**
     * Critério da consulta
     * @var SQLCriteria;
     */
    protected $criteria;  // armazena o objeto critério
    protected $entity;

    /**
     * método setEntity()
     * define o nome da entidade (tabela) manipulada pela instrução SQL
     * @param $entity = tabela
     */
    final public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * método getEntity()
     * retorna o nome da entidade (tabela)
     */
    final public function getEntity()
    {
        return $this->entity;
    }

    /**
     * método setCriteria()
     * Define um critério de seleção dos dados através da composição de um objeto
     * do tipo TCriteria, que oferece uma interface para definição de critérios
     * @param $criteria = objeto do tipo TSqlExpression
     */
    public function setCriteria(SQLExpression $criteria)
    {
        $this->criteria = $criteria;
    }

    /**
     * método getSQL()
     * declarando-o como <abstract> obrigamos sua declaração nas classes filhas,
     * uma vez que seu comportamento será distinto em cada uma delas, configurando polimorfismo.
     */
    abstract function getStatement();
}
