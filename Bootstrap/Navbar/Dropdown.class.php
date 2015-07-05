<?php

namespace Prime\Bootstrap\Navbar;

use Prime\Html\Base\HTMLElement;

/**
 * Descrição de Dropdown
 * @name Dropdown
 * @package Prime\Bootstrap\Navbar
 * @create 22/03/2014
 * @access public
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
class Dropdown extends HTMLElement {

    public function __construct($id) {
        parent::__construct('ul');
        parent::setAttribute('class', 'dropdown-menu');
        if (!is_null($id)) {
            parent::setAttribute('id', $id);
        }
    }

    /**
     * Adiciona um ítem ao dropdown
     * @param type $text
     * @param type $href
     * @return \Prime\Bootstrap\Navbar\NavbarItem
     */
    public function addItem($text = "Novo Menu", $href = "#") {
        $item = new NavbarItem($text, $href);
        parent::appendChild($item);

        return $item;
    }
    
    public function addSeparator(){
        $item = new HTMLElement('li');
        $item->appendChild('');
        $item->setAttribute('class', 'divider');
        parent::appendChild($item);
    }

}
