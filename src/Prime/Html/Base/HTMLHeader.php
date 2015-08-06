<?php

namespace Prime\Html\Base;

/**
 * Descrição de HTMLHeader
 * Cabeçalhos HTML <br>
 * Cria uma Tag HTML h1 a h6 de acordo com o parâmetro passado
 * @author tom
 * @since 28/01/2012
 */
class HTMLHeader extends HTMLElement
{

    /**
     * Cria uma Tag HTML h1 a h6 de acordo com o parâmetro passado
     * @param int $num 
     */
    public function __construct($num = 1)
    {
        if ($num > 0 || $num < 7) {
            parent::__construct('h' . $num);
        } else {
            trigger_error('Parâmetro inválido em: ' . __CLASS__ . 'em seu construtor.', E_USER_ERROR);
        }
    }

}
