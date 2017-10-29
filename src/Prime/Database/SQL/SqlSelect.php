<?php

namespace Prime\Database\SQL;

use Prime\Core\TString;

/**
 * Classe para criação de uma intrução SQL para leitura de dados no SGBD
 *
 * @author Tom Sailor
 */
class SqlSelect extends AbstractStatement {

    /**
     * Armazena as colunas que deverão ser retornadas na execução da Instrução 
     * Select
     * @var string[]
     */
    private $columns = [];

    /**
     *
     * @var sql
     */
    private $criteria;
    private $groupBy;
    private $having;
    private $orderBy;
    private $limit;
    private $offset;

    /**
     * Cria um objeto do tipo SqlSelect para criação de uma declaração SQL que
     * retorna um conjunto de resultados de registros de uma ou mais tabelas
     * @param string $entityName
     */
    public function __construct(string $entityName, string $alias = NULL) {
        $this->setEntity($entityName, $alias);
    }

    /**
     * Retorna um array contendo as columnas utilizadas ou vazio caso não tenha
     * sido predefinidos colunas para serem retornadas na instrução SQL
     * @return array
     */
    public function getColumns(): array {
        return $this->columns;
    }

    /**
     * Adiciona uma coluna a ser retornada pelo SELECT
     * @param string $column O nome da tabela 
     */
    public function addColumn(SqlColumn $column) {
        $this->columns[] = $column;
    }

    /**
     * 
     * @return string
     */
    public function getStatement(): string {
        $string = new TString('SELECT ');

        $string->concat(implode(', ', $this->getColumns()));

        $string->concat(' FROM ' . $this->getEntity());

        $this->statement = $string->getValue();

        return $this->statement;
    }

    /**
     * Define os critérios de busca
     * @param \Prime\Database\SQL\ExpressionInterface $criteria
     */
    public function setCriteria(ExpressionInterface $criteria) {
        $this->criteria = $criteria;
    }

    /**
     * Retorna um objeto contendo os critérios de busca
     * @return \Prime\Database\SQL\ExpressionInterface
     */
    public function getCriteria(): ExpressionInterface {
        return $this->criteria;
    }

}
