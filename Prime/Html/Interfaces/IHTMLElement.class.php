<?php

namespace Prime\Html\Interfaces;

use Prime\View\IView;

/**
 * Descrição da Interface IHTMLElement
 * @author tom
 */
interface IHTMLElement extends IView {

    public function setAttribute($name, $value);

    public function getAttribute($name);

    public function appendChild($child);

    public function prependChild($child);
}


