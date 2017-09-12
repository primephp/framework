<?php

namespace Prime\Core\Interfaces;

/**
 * Definição da Interface IAutoCloseable
 * Um recurso que deve ser fechado quando não é mais necessário.
 * @name IAutoCloseable
 * @package Prime\core
 * @dateCreate 10/06/2014
 * @author Elton Luiz
 */
interface IAutoCloseable {

    /**
     * Fecha este recurso, abandonando todos os recursos subjacentes.
     */
    public function close();
}
