<?php

namespace Prime\Bootstrap\Navbar;

use Prime\Html\Base\HTMLDiv,
    Prime\Html\Base\HTMLElement,
    Prime\Html\Base\HTMLImage,
    Prime\Html\Base\HTMLSpan;

/**
 * Descrição de Navbar
 * @name Navbar
 * @package Prime\Bootstrap
 * @create 22/03/2014
 * @access public
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
class Navbar extends HTMLElement {

    private $brand = 'LOGO';
    private $align = 'left';

    public function __construct($id = NULL) {
        parent::__construct('ul');

        if (!is_null($id)) {
            parent::setAttribute('id', $id);
        }
    }

    public function setLogo($src) {
        $this->brand = $src;
    }

    /**
     * Adiciona um item à barra de navagação
     * @param type $text
     * @param type $href
     * @return NavbarItem
     */
    public function addItem($text = "Novo Menu", $href = "#") {
        $item = new NavbarItem($text, $href);
        parent::appendChild($item);

        return $item;
    }

    protected function header() {
        $div = new HTMLDiv();
        $div->setAttribute('class', 'navbar-header');

        $button = new HTMLElement('button');
        $button->setAttribute('type', 'button');
        $button->setAttribute('class', 'navbar-toggle');
        $button->setAttribute('data-toggle', 'collapse');
        $button->setAttribute('data-target', '#navbar');

        $span = new HTMLSpan('');
        $span2 = clone $span;
        $span->appendChild('Alternar navegação');
        $span->setAttribute('class', 'sr-only');
        $button->appendChild($span);
        $span2->setAttribute('class', 'icon-bar');
        $button->appendChild($span2);
        $span3 = clone $span2;
        $button->appendChild($span3);
        $span4 = clone $span2;
        $button->appendChild($span4);

        $div->appendChild($button);
        $div->appendChild($this->getBrand());

        return $div;
    }

    private function getBrand() {
        $img = new HTMLImage($this->brand);
        $img->setMaximumSize(55,55);
        $img->setAttribute('class', 'navbar-brand');
        return $img;
    }

    /**
     * 
     * @return HTMLDiv
     */
    private function containerFluid() {
        $div = new HTMLDiv();
        $div->setAttribute('class', 'container-fluid');
        return $div;
    }

    /**
     * 
     * @return HTMLDiv
     */
    private function collapse() {
        $div = new HTMLDiv('navbar');
        $div->setAttribute('class', 'collapse navbar-collapse');
        return $div;
    }

    public function setAlign($align = 'left') {
        $this->align = $align;
    }

    public function getOutput($complete = FALSE) {
        parent::setAttribute('class', 'nav navbar-nav navbar-' . $this->align);
        if ($complete) {
            $main = new HTMLElement('nav');
            $main->setAttribute('class', 'navbar navbar-default');
            $main->setAttribute('role', 'navigation');

            $collapse = $this->collapse();
            $collapse->appendChild(parent::getOutput());
            $fluid = $this->containerFluid();
            $fluid->appendChild($this->header());
            $fluid->appendChild($collapse);

            $main->appendChild($fluid);
            return $main->getOutput();
        } else {
            return parent::getOutput();
        }
    }

    public function addNavbar($align) {
        
    }

}
