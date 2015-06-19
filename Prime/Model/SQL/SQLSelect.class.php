<?php

namespace Prime\Model\SQL;

/*
 * classe SQLSelect
 * @package Prime\Model\SQL
 * Esta classe provê meios para manipulação de uma instrução de SELECT no banco de dados
 */

final class SQLSelect extends SQLStatement {

    private $columns;     // array de colunas a serem retornadas.

    /*
     * método addColumn
     * adiciona uma coluna a ser retornada pelo SELECT
     * @param $column = coluna da tabela
     */

    public function addColumn($column) {
        // adiciona a coluna no array
        $this->columns[] = $column;
    }

    /*
     * método getSQL()
     * retorna a instrução de SELECT em forma de string.
     */

    public function getStatement() {
        // monta a instrução de SELECT
        $this->sql = 'SELECT ';

        // monta string com os nomes de colunas
        $this->sql .= implode(',', $this->columns);

        // adiciona na cláusula FROM o nome da tabela
        $this->sql .= ' FROM ' . $this->entity;

        // obtém a cláusula WHERE do objeto criteria.
        if ($this->criteria) {
            $expression = $this->criteria->dump();
            if ($expression) {
                $this->sql .= ' WHERE ' . $expression;
            }

            // obtém as propriedades do critério
            if ($this->criteria instanceof SQLCriteria) {
                $order = $this->criteria->getProperty(SQLCriteria::ORDER_BY);
                $limit = $this->criteria->getProperty(SQLCriteria::LIMIT);
                $offset = $this->criteria->getProperty(SQLCriteria::OFFSET);
                $group = $this->criteria->getProperty(SQLCriteria::GROUP_BY);
            }

            // obtém a ordenação do SELECT
            if (!empty($group)) {
                $this->sql .= ' GROUP BY ' . $group;
            }
            if (!empty($order)) {
                $this->sql .= ' ORDER BY ' . $order;
            }

            if (!empty($limit)) {
                $this->sql .= ' LIMIT ' . $limit;
            }
            if (!empty($offset)) {
                $this->sql .= ' OFFSET ' . $offset;
            }
        }
        return $this->sql;
    }

}

