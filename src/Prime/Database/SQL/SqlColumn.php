<?php

namespace Prime\Database\SQL;

/**
 * Classe representa uma única coluna numa instrução SQL
 *
 * @author Tom Sailor
 */
class SqlColumn extends AbstractExpression {

    /**
     *
     * @var string nome da coluna na tabela
     */
    private $name = NULL;

    /**
     * @var string alias para a coluna
     */
    private $alias = NULL;

    /**
     * Cria uma objeto do tipo COlumn responsábel por representar o nome de
     * uma coluna de uma entidade de um SGBD
     * @param string $name Nome da coluna na tabela do SGBD
     * @param string $alias O álias a ser utilizado na coluna
     */
    public function __construct(string $name, $alias = NULL) {
        $this->name = $name;
        if (!is_null($alias)) {
            $this->alias = $alias;
        }
    }

    /**
     * Retorna o nome da coluna
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * 
     */
    public function dump(): string {
        $string = new \Prime\Core\TString($this->name);
        if (!is_null($this->alias)) {
            $string->concat(' AS ' . $this->alias);
        }
        return $string->getValue();
    }

}
