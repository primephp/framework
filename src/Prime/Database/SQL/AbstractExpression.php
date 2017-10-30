<?php

namespace Prime\Database\SQL;

/**
 * Implementa uma insterface para a criação de instruções SQL
 *
 * @author Tom Sailor
 */
abstract class AbstractExpression implements ExpressionInterface
{

    /**
     * Retorna o conteúdo da expressão SQL como uma string
     * @return string
     */
    public function __toString(): string
    {
        return $this->dump();
    }

}
