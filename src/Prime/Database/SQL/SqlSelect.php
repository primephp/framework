<?php

namespace Prime\Database\SQL;

use Prime\Core\TString;

/**
 * Classe para criação de uma intrução SQL para leitura de dados no SGBD
 *
 * @author Tom Sailor
 */
class SqlSelect extends AbstractStatement
{

    use SqlCriteriaExpression;

    /**
     * Armazena as colunas que deverão ser retornadas na execução da Instrução 
     * Select
     * @var string[]
     */
    private $columns = [];

    /**
     * @var SqlGroupBy
     */
    private $groupBy;
    private $having;

    /**
     * @var SqlOrderBy
     */
    private $orderBy;
    private $limit;
    private $offset;

    /**
     * Cria um objeto do tipo SqlSelect para criação de uma declaração SQL que
     * retorna um conjunto de resultados de registros de uma ou mais tabelas
     * @param string $entityName
     */
    public function __construct(string $entityName, string $alias = NULL)
    {
        $this->setEntity($entityName, $alias);
    }

    /**
     * Retorna um array contendo as columnas utilizadas ou vazio caso não tenha
     * sido predefinidos colunas para serem retornadas na instrução SQL
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * Adiciona uma coluna a ser retornada pelo SELECT
     * @param string $column O nome da tabela 
     */
    public function addColumn(SqlColumn $column)
    {
        $this->columns[] = $column;
    }

    /**
     * Adicionar um array de colunas a seres retornadas pela instrução select
     * @param SqlColumn[] $columns
     */
    public function addColumns(array $columns)
    {
        foreach ($columns as $column) {
            $this->addColumn($column);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getStatement(): string
    {
        $string = new TString('SELECT ');

        $string->concat($this->_getColumns());

        $string->concat(' FROM ' . $this->getEntity());

        if (!is_null($this->criteria)) {
            $string->concat(' WHERE ' . $this->criteria->dump());
        }

        if (!is_null($this->groupBy)) {
            $string->concat(' GROUP BY ' . $this->groupBy->dump());
        }

        if (!is_null($this->orderBy)) {
            $string->concat(' ORDER BY ' . $this->orderBy->dump());
        }

        if (!is_null($this->limit)) {
            $string->concat(' LIMIT ' . $this->getLimit());
        }

        if (!is_null($this->offset)) {
            $string->concat(' OFFSET ' . $this->getOffset());
        }

        $this->statement = $string->getValue();

        return $this->statement;
    }

    /**
     * Retorna as colunas (campos) da tabelas que serão utilizadas no instrução
     * Select, caso não tenha sido definido retorna '*', indicando que deverão
     * retornar todas as colunas
     * @return string
     */
    private function _getColumns(): string
    {
        if (count($this->columns)) {
            return implode(', ', $this->getColumns());
        }
        return ' * ';
    }

    /**
     * Retorna o objeto que define o agrupamento dos resultados da consulta
     * @return \Prime\Database\SQL\SqlGroupBy
     */
    public function getGroupBy(): SqlGroupBy
    {
        return $this->groupBy;
    }

    /**
     * @todo Implementa o HAVING no select
     * @return type
     */
    public function getHaving()
    {
        return $this->having;
    }

    /**
     * Retorna o objeto que define o ordenamento dos objetos da consulta
     * @return \Prime\Database\SQL\SqlOrderBy
     */
    public function getOrderBy(): SqlOrderBy
    {
        return $this->orderBy;
    }

    /**
     * Retorna o valor do limite de linhas que devem ser retornadas
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Retorna o valor de linhas que devem ser puladas antes de começar a retornas
     * os registros
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * Define o agrupamento da consulta
     * @param \Prime\Database\SQL\SqlGroupBy $groupBy
     * @return $this
     */
    public function setGroupBy(SqlGroupBy $groupBy)
    {
        $this->groupBy = $groupBy;
        return $this;
    }

    /**
     * @todo Implementa o HAVING no select
     * @param type $having
     * @return $this
     */
    public function setHaving($having)
    {
        $this->having = $having;
        return $this;
    }

    /**
     * Define o ordenamento do resultado da consulta
     * @param \Prime\Database\SQL\SqlOrderBy $orderBy
     * @return $this
     */
    public function setOrderBy(SqlOrderBy $orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * Define o limite de linhas que devem ser retornadas
     * @param int $limit
     * @return $this
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Define a quantidade de linhas que devem ser puladas antes
     * de começar a retornar os registros
     * @param int $offset
     * @return $this
     */
    public function setOffset(int $offset)
    {
        $this->offset = $offset;
        return $this;
    }

}
