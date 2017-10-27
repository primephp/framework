<?php

namespace Prime\Database\SQL;

/**
 * Description of EntityName
 *
 * @author 85101346
 */
class EntityName extends \Prime\Database\SQL\AbstractExpression {

    /**
     * Nome da Entidade 
     * @var string
     */
    private $name;

    /**
     * Alias para identificação da entidade
     * @var string
     */
    private $alias;

    public function __construct(string $name, string $alias = null) {
        $this->setName($name);
        if (!is_null($alias)) {
            $this->setAlias($alias);
        }
    }

    /**
     * Define o nome da entidade(tabela)
     * @param string $name
     */
    private function setName(string $name) {
        $this->name = $name;
    }

    /**
     * Define um alias para a entidade(tabela)
     * @param string $alias
     */
    private function setAlias(string $alias) {
        $this->alias = $alias;
    }

    /**
     * Retorna o nome da entidade(tabela)
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Retona o nome-alias definido para a entidade(tabela)
     * @return string
     */
    public function getAlias(): string {
        if (is_null($this->alias)) {
            return $this->name;
        }
        return $this->alias;
    }

    /**
     * {@inheritDoc}
     */
    public function dump(): string {
        $value = $this->getName();
        if (!is_null($this->alias)) {
            $value .= " AS $this->alias";
        }
        return $value;
    }

}
