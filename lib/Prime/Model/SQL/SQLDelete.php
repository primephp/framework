<?php

namespace Prime\Model\SQL;

/**
 * classe SQLDelete
 * @package Prime\Model\SQL
 * Esta classe provê meios para manipulação de uma instrução de DELETE no banco de dados
 */
final class SQLDelete extends SQLStatement {

    /**
     * método getSQL()
     * retorna a instrução de DELETE em forma de string.
     */
    public function getStatement() {
        // monta a string de DELETE
        $this->sql = "DELETE FROM {$this->entity}";

        // retorna a cláusula WHERE do objeto $this->criteria
        if ($this->criteria) {
            $expression = $this->criteria->dump();
            if ($expression) {
                $this->sql .= ' WHERE ' . $expression;
            }
        }
        return $this->sql;
    }

}
