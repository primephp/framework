<?php

namespace Prime\Html\Widget;

use Prime\Html\Base\HTMLDiv;

/**
 * Descrição da Classe StaticPanel
 *
 * @copyright Copyright &copy; 2011, www.eltonluiz@hotmail.com
 * @since 24/03/2011
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
class StaticPanel extends HTMLDiv
{

    /**
     *  @var $title HTMLDiv
     */
    private $title;
    private $titleText = "Mensagem";
    private $panel;
    private $footer = [];

    public function __construct($nameId = null)
    {
        parent::__construct($nameId);
        $this->addClass('box box-primary');

        $this->title = new HTMLDiv();
        $this->title->class = "box-header";
        $this->title->setStyle('text-align', 'center');

        $this->panel = new HTMLDiv();
        $this->panel->class = "box-body";

        $this->footer = new HTMLDiv();
        $this->footer->setAttribute('class', 'box-footer');

        return $this;
    }

    public function divContentSetStyle($property, $value)
    {
        $this->panel->setStyle($property, $value);
    }

    /**
     * Defina o Título do Panel
     * @param string $title
     * @param string $size 
     */
    public function setTitle($title, $size = NULL)
    {
        if (!is_null($size)) {
            if ($size < 20) {
                $this->title->setStyle("font-size", $size . "px");
            } else {
                $this->title->setStyle("font-size", "20px");
            }
        } else {
            $this->title->setStyle("font-size", "15px");
        }
        $this->titleText = $title;
    }

    /**
     * Adiciona conteúdo dentro do Panel
     * @param mixed $child 
     */
    public function appendChild($child)
    {
        $this->panel->appendChild($child);
    }

    public function addFooterContent($content)
    {
        $this->footer->appendChild($content);
    }

    private function getTitle()
    {
        $this->title->appendChild($this->titleText);

        return $this->title->getOutput();
    }

    public function getOutput()
    {
        parent::appendChild($this->getTitle());

        parent::appendChild($this->panel);

        if ($this->footer->hasChildren()) {
            parent::appendChild($this->footer);
        }
        return parent::getOutput();
    }

}
