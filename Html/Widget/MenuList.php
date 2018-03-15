<?php

namespace Prime\Html\Widget;

use Prime\Html\Base\HTMLAnchor,
    Prime\Html\Base\HTMLElement;

/**
 * Descrição da Classe Menu
 *
 * @copyright Copyright &copy; 2011, www.eltonluiz@hotmail.com
 * @since 21/03/2011
 * @author Elton Luiz <www.eltonluiz@hotmail.com>
 */
class MenuList extends HTMLElement
{
    /* @var HTMLElement $menu */

    private $menu;
    private $menuItens;

    public function __construct()
    {
        parent::__construct('ul');
        $this->menu = new HTMLElement("ul");
    }

    /**
     * 
     * @param type $text
     * @param type $href
     * @param type $target
     * @return HTMLElement Retorna um objeto HTMLElement(li)
     */
    public function addItem($text = "Novo Menu", $href = "#", $target = NULL)
    {
        //Cria um elemento HTML ListItem
        $item = new HTMLElement("li");
        //Cria um elemento HTML Anchor
        $newAnchor = new HTMLAnchor($href, $text, $target);

        //adiciona o Anchor dentro do ListItem
        $item->appendChild($newAnchor);
        //adiciona a lista
        parent::appendChild($item);

        return $item;
    }

    /**
     * Cria um novo ListItem adicionando a ele um Objeto HTMLAnchor
     * passado como parâmetro, diferente do AddItem, que cria um listItem
     * e um HTML de acordo com os parâmetros passados
     * @param HTMLAnchor $anchor 
     */
    public function addLink(HTMLAnchor $anchor)
    {
        //Cria um elemento HTML ListItem
        $item = new HTMLElement("li");
        $item->appendChild($anchor);

        parent::appendChild($item);
    }

    public function printOut()
    {
        echo $this->getOutput();
    }

    public function addMenuList(MenuList $menu)
    {
        $this->menuItens[] = $menu;
    }

}
