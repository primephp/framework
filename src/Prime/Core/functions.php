<?php

/**
 * Executa um dump do valor passado e finaliza 
 * o fluxo da aplicação
 * @param type $value
 */
function dd($value) {
    var_dump($value);
    die();
}
