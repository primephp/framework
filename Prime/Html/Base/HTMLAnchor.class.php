<?php

namespace Prime\Html\Base;

use Prime\Config\IMouseEvent,
    Prime\Http\Url;

class HTMLAnchor extends HTMLElement {

    /**
     * configuracao interna de dados
     */
    private $text;

    /**
     *
     * @param string $href
     */
    public function __construct($href = '', $text = '', $target = null) {
        if ($href instanceof Url) {
            $href = $href->queryString();
        }
        parent::__construct("a");
        $this->text = $text;
        $this->href = "$href";
        if (isset($target)) {
            $this->target = $target;
        }
    }

    /**
     * 
     */
    public function setAssync() {
        $this->setAttribute(IMouseEvent::CLICK, 'return $.callAssync(this);');
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getOutput() {
        $this->appendChild($this->text);
        return parent::getOutput();
    }

}
