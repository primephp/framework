<?php

namespace Prime\Html\Base;

/**
 * Descrição da Classe HTMLList
 * @name HTMLList
 * @package HTML
 * @subpackage HTMLElements
 * @subpackage HTMLList
 * @version 1.0
 * @author Elton Luiz
 * @since 29/10/2011
 * @access public
 */
class HTMLList extends HTMLElement
{

    const T_UNORDERED = 0;
    const T_ORDERED = 1;
    const T_DEFINITION = 2;
    const LS_CIRCLE = 'circle';
    const LS_DISC = 'disc';
    const LS_NONE = 'none';

    private $itens = [];

    public function __construct($type = HTMLList::T_UNORDERED, $listStyle = HTMLList::LS_NONE)
    {
        if ($type == self::T_ORDERED) {
            parent::__construct('ol');
        } else {
            parent::__construct('ul');
        }
        $this->setListStyle($listStyle);
    }

    public function addItem($content)
    {
        $child = new HTMLElement('li');
        $child->appendChild($content);

        parent::appendChild($child);

        return $child;
    }

    public function setListStyle($style = 'none')
    {
        $this->setStyle('list-style', $style);
    }

}
