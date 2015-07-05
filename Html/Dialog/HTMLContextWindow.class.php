<?php

namespace Prime\Html\Dialog;

use Prime\Html\Base\HTMLDiv,
    Prime\Html\Style\HTMLStyle;

/**
 * @package Prime\Html\Dialog
 */
final class HTMLContextWindow {

    private $wnd;
    private $w_id;
    private $t = 0;
    private $l = 0;
    private $wth;
    private $hgt;
    private $content;
    private static $counter = 0;

    /**
     * Constroi uma janela para receber elementos de tela
     *
     * @param string $object
     * @param int $width
     * @param int $height
     */
    public function __construct($object, $width = 420, $height = 320) {
        $this->content = $object;
        $this->wth = intval($width);
        $this->hgt = intval($height);
        $this->titleAlign = "left";
        $this->w_id = uniqid("WCtx_");
        $this->wnd = new HTMLDiv();
        $this->wnd->dialog = "DIALOG";
        //$this->wnd->id = $this->w_id;
    }

    /**
     * Define a linha e a coluna em pixel para o posicionamento da janela
     *
     * @param mixed $top
     * @param mixed $left
     */
    public function setPosition($top, $left) {
        $this->t = $top;
        $this->l = $left;
    }

    /**
     * Computa e forma a janela conforme especificado e retorna uma string que pode ser usada
     * diretamente na tela do cliente assim como tambem pode completar espa�os de
     * documentos HTML.
     * @return string
     */
    public function getOutput() {
        $w_id = $this->w_id;
        $cssLook = $this->createLook($w_id);
        $posLeft = (strpos($this->l, "%")) ? $this->l : $this->l . "px";
        $posTop = (strpos($this->t, "%")) ? $this->t : $this->t . "px";
        $this->wnd->setAttribute("style", "position:absolute;left:{$posLeft};top:{$posTop};overflow:auto;");
        $this->wnd->setAttribute("class", "$w_id");
        $this->wnd->appendChild($this->content);
        //-------------------------------------------------------------------
        return $cssLook . $this->wnd->getOutput();
    }

    /**
     * Imprime a janela computada diretamente na saida do servidor
     * @return void
     */
    public function printOut() {
        echo $this->getOutput();
    }

    /**
     *
     *
     * @param string $class
     */
    private function createLook($class) {
        $style = new HTMLStyle("$class");
        $style->width = "{$this->wth}px";
        $style->height = ($this->hgt + 2) . "px";
        $style->border = "1px solid  #E7E7F1";
        $style->background_color = "#FAFAFB";
        //$style->z_index = self::$counter + "100000";
        return $style->getOutput();
    }

    public function getDialogId() {
        return $this->w_id;
    }

}

