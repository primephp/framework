<?php

namespace Prime\Core\Interfaces;

/**
 * Definição da Interface AutoCloseableInterface
 * Um recurso que deve ser fechado quando não é mais necessário.
 * @name AutoCloseableInterface
 * @package Prime\core
 * @dateCreate 10/06/2014
 * @author Elton Luiz
 */
interface AutoCloseableInterface
{

    /**
     * Fecha este recurso, abandonando todos os recursos subjacentes.
     */
    public function close();
}
