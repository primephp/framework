<?php

namespace Prime\Html\Interfaces;

use Prime\View\ViewInterface;

/**
 * Descrição da Interface IHTMLElement
 * @author tom
 */
interface IHTMLElement extends ViewInterface
{

    public function setAttribute($name, $value);

    public function getAttribute($name);

    public function appendChild($child);

    public function prependChild($child);
}
