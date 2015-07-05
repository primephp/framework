<?php

namespace Prime\Bootstrap\Navbar;

use Prime\Html\Base\HTMLAnchor,
    Prime\Html\Base\HTMLElement;

/**
 * Descrição de NavbarItem
 * @name NavbarItem
 * @package Prime\Bootstrap\Navbar
 * @create 22/03/2014
 * @access public
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
class NavbarItem extends HTMLElement {

    private $text;
    private $href;
    private $dropDown = FALSE;
    private $dropdownContent;

    public function __construct($text = "Novo Menu", $href = "#") {
        $this->text = $text;
        $this->href = $href;
        parent::__construct('li');
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getOutput() {
        $newAnchor = new HTMLAnchor($this->href, $this->text);
        if ($this->dropDown) {
            $newAnchor->setAttribute('class', 'dropdown-toggle');
            $newAnchor->setAttribute('data-toggle', 'dropdown');
            $b = new HTMLElement('b');
            $b->setAttribute('class', 'caret');
            $newAnchor->appendChild($b);
            parent::setAttribute('class', 'dropdown');
        }
        parent::appendChild($newAnchor);
        parent::appendChild($this->dropdownContent);
        return parent::getOutput();
    }

    /**
     * Adiciona um menu dropdown a barra de menus
     * @param Dropdown $dropdown
     */
    public function addDropdownMenu(Dropdown $dropdown) {
        $this->dropDown = TRUE;
        $this->dropdownContent = $dropdown;
    }

}
