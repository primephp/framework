<?php

namespace Prime\View;

/**
 * Define a interface para objetos imprimíveis em tela
 * @author tom
 * @package Prime\View
 */
interface IPrintable {

    /**
     * Imprime na tela o conteúdo do objeto
     */
    public function printOut();
}
