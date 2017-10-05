<?php

namespace Prime\View;

use Prime\Io\PrintableInterface;

/**
 * Defini a Interface para as classes de Visualização
 * @author Elton Luiz
 * @package Prime\View
 */
interface ViewInterface extends PrintableInterface
{

    /**
     * Retorna o Conteúdo da imprimível na tela 
     */
    public function getOutput();
}
