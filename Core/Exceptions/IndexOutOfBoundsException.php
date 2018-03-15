<?php

namespace Prime\Core\Exceptions;

use RuntimeException;

/**
 * Lançado para indicar que um índice de algum tipo (como para uma matriz, uma
 * string, ou um vetor) está fora do intervalo.
 * @author Elton Luiz
 * @createAt 15/08/2016
 */
class IndexOutOfBoundsException extends RuntimeException
{

    /**
     * Contrutor de IndexOutOfBoundsException
     * @param string $message Mensagem que deve ser exibida na exceção
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }

}
