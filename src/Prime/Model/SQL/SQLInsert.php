<?php

namespace Prime\Model\SQL;

/*
 * classe SQLInsert
 * @package Prime\Model\SQL
 * Esta classe provê meios para manipulação de uma instrução de INSERT no banco de dados
 */

final class SQLInsert extends SQLStatement {

    private $columnValues;

    /**
     * método setRowData()
     * Atribui valores à determinadas colunas no banco de dados que serão inseridas
     * @param $column = coluna da tabela
     * @param $value = valor a ser armazenado
     */
    public function setRowData($column, $value) {
        // verifica se é um dado escalar (string, inteiro, ...)
        if (is_scalar($value)) {
            if (is_string($value) and ( !empty($value))) {
                // adiciona \ em aspas
                $value = addslashes($value);
                // caso seja uma string
                $this->columnValues[$column] = "'$value'";
            } else if (is_bool($value)) {
                // caso seja um boolean
                $this->columnValues[$column] = $value ? 'TRUE' : 'FALSE';
            } else if ($value !== '') {
                // caso seja outro tipo de dado
                $this->columnValues[$column] = $value;
            } else {
                // caso seja NULL
                $this->columnValues[$column] = "NULL";
            }
        }
    }

    /**
     * método setCriteria()
     * não existe no contexto desta classe, logo, irá lançar um erro ser for executado
     */
    public function setCriteria(SQLExpression $criteria) {
        // lança o erro
        throw new Exception("Não pode chamar o método setCriteria de " . __CLASS__);
    }

    /**
     * método getStatement()
     * retorna a instrução de INSERT em forma de string.
     */
    public function getStatement() {
        $this->sql = "INSERT INTO {$this->entity} (";
        // monta uma string contendo os nomes de colunas
        $columns = implode(', ', array_keys($this->columnValues));
        // monta uma string contendo os valores
        $values = implode(', ', array_values($this->columnValues));
        $this->sql .= $columns . ')';
        $this->sql .= " values ({$values})";
        return $this->sql;
    }

}
