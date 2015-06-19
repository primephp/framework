<?php

namespace Prime\Html\Base;

/**
 * Descrição da Classe HTMLList
 * @name HTMLList
 * @package HTML
 * @subpackage HTMLElements
 * @subpackage HTMLList
 * @version 1.0
 * @author tom
 * @since 29/10/2011
 * @access public
 */
class HTMLList extends HTMLElement {

    const T_UNORDERED = 0;
    const T_ORDERED = 1;
    const T_DEFINITION = 2;
    const LS_CIRCLE = 'circle';
    const LS_DISC = 'disc';
    const LS_NONE = 'none';

    private $itens = array();

    public function __construct($type = HTMLList::T_UNORDERED, $listStyle = HTMLList::LS_NONE) {
        if ($type == self::T_ORDERED) {
            parent::__construct('ol');
        } else {
            parent::__construct('ul');
        }
        $this->setListStyle($listStyle);
    }

    public function addItem($item) {
        $child = new HTMLElement('li');
        $child->appendChild($item);

        parent::appendChild($child);

        return $child;
    }

    public function setListStyle($style = 'none') {
        $this->setStyle('list-style', $style);
    }

}


