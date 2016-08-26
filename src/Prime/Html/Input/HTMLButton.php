<?php

namespace Prime\Html\Input;

/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL - 2008
 *
 *
 * Concluida
 *
 */
class HTMLButton extends HTMLInput {

    /**
     * Cria um elemento HTML Button
     * @param string $name
     * @param bool $assync se TRUE o evento será executado de maneira assíncrona
     */
    public function __construct($name, $assync = FALSE) {
        parent::__construct();
        $this->element->type = "button";
        $this->element->name = $name;
        $this->element->id = $name;

        /**
         * Para que seja utilizável a chamada assíncrona do HTMLAnchor, é necessário
         * que esteja fixo no arquivos functions do Framework a referida função
         */
        if ($assync) {
            $this->element->setAttribute(IMouseEvent::CLICK, 'return $.callAssync(this);');
        }
    }

}
