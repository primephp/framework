<?php

namespace Prime\Html\Dialog;

use Prime\Html\Base\HTMLElement,
    Prime\Html\Style\HTMLStyleInline,
    Prime\View\View;

class HTMLPanel extends View {

    private $panel;
    private $id;
    private $style;

    public function __construct($width = 300, $height = 150, $border = 0) {
        $this->style = new HTMLStyleInline();
        $this->panel = new HTMLElement("div");
        $this->id = 'panel_' . uniqid();
        $this->height = $height;
        $this->width = $width;
        $this->borderWidth = $border;
        $this->borderColor = "#8294AF";
        $this->borderStyle = "solid";
        $this->backgroundColor = "#E8F0FC";
        $this->fontSize = "11";
        $this->fontFamily = "Sans Serif";
        $this->top = "0";
        $this->left = "0";
        $this->overflow = "hidden";
    }

    public function getId() {
        return $this->id;
    }

    /**
     * adiciona um HTMLElement em uma posicao especificada dentro painel
     *
     * @param HTMLElement $child
     * @param int $row
     * @param int $col
     */
    public function appendChild($child, $top = 0, $left = 0) {
        //cria uma div para o elemento filho
        $camada = new HTMLElement("div");
        //define a posicao da camada
        $style = new HTMLStyleInline();
        $style->setProperty('position', 'absolute');
        $style->setProperty('top', $top . 'px');
        $style->setProperty('left', $left . 'px');
        $style->setProperty('padding', '0px');
        $style->setProperty('margin', '0px');
        $style->setProperty('border', 'none');
        $camada->setAttribute('style', $style->getOutput());
        $camada->appendChild($child);
        $this->panel->appendChild($camada);
    }

    private function createLook() {
        $this->style->setProperty('position', 'absolute');
        $this->style->setProperty('min-width', $this->width . 'px');
        $this->style->setProperty('min-height', $this->height . 'px');
        $this->style->setProperty('left', $this->left . 'px');
        $this->style->setProperty('top', $this->top . 'px');
        $this->style->setProperty('padding', '5px');
        $this->style->setProperty('border', $this->borderWidth . 'px ' . $this->borderStyle . ' ' . $this->borderColor);
        //$this->style->setProperty('overflow', 'hidden');


        return $this->style->getOutput();
    }

    /**
     * Define o valor de uma propriedade CSS
     * @param string $name
     * @param string $value 
     */
    public function setStyle($name, $value) {
        $this->style->setProperty($name, $value);
    }

    /**
     * Define a altura e a largura da janela na tela
     *
     * @param integer $width
     * @param integer $height
     */
    public function setSize($width = 350, $height = 150) {
        $this->width = intval($width);
        $this->height = intval($height);
    }

    public function setPosition($top, $left) {
        $this->top = $top;
        $this->left = $left;
    }

    public function setAttribute($name, $value) {
        $this->panel->setAttribute($name, $value);
    }

    /**
     * Retorna a altura do painel
     * @return int 
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * Retorna a larguda do painel
     * @return int 
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     *
     * @return string
     */
    public function getOutput() {
        $this->panel->setAttribute('style', $this->createLook());
        $this->panel->setAttribute('class', 'ui-widget ui-corner-bottom');
        $this->panel->setAttribute('id', $this->getId());
        return $this->panel->getOutput();
    }

}
