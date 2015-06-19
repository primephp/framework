<?php

namespace Prime\Html\Widget;

use Prime\Html\Base\HTMLDiv,
    Prime\Html\Base\HTMLHeader;

/**
 * Descrição da Classe StaticPanel
 *
 * @copyright Copyright &copy; 2011, www.eltonluiz@hotmail.com
 * @since 24/03/2011
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
class StaticPanel extends HTMLDiv {
    /* @var $title HTMLDiv
     */

    private $title;
    private $titleText = "Mensagem";
    private $panel;

    public function __construct($nameId = null) {
        parent::__construct($nameId);
        $this->class = "staticPanel";

        $this->title = new HTMLHeader(1);
        $this->title->class = "ui-widget ui-corner-top ui-widget-header";
        $this->title->setStyle('text-align', 'center');
        $this->title->setStyle('margin', '0');
        $this->title->setStyle('padding', '5px');

        $this->panel = new HTMLDiv();
        $this->panel->setStyle('padding', '10px');
        $this->panel->class = "ui-widget ui-widget-content";

        return $this;
    }

    public function divContentSetStyle($property, $value) {
        $this->panel->setStyle($property, $value);
    }

    /**
     * Defina o Título do Panel
     * @param string $title
     * @param string $size 
     */
    public function setTitle($title, $size = NULL) {
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
    public function appendChild($child) {
        $this->panel->appendChild($child);
    }

    public function getOutput() {
        //adiciona o texto do título
        $this->title->appendChild($this->titleText);
        //adiciona a barra de título
        parent::appendChild($this->title);
        //adiciona o panel de conteúdo
        parent::appendChild($this->panel);
        return parent::getOutput();
    }

}


