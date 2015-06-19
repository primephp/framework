<?php

namespace Prime\View;

/**
 * Defini a Interface para as classes de Visualização
 * @author tom
 * @package Prime\View
 */
interface IView extends IPrintable {

    /**
     * Retorna o Conteúdo da imprimível na tela 
     */
    public function getOutput();
}