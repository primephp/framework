<?php

namespace Prime\Bootstrap\Panel;

use Prime\Html\Base\HTMLDiv,
    Prime\Html\Base\HTMLHeader,
    Prime\View\View;

/**
 * Descrição de AbstractPanel
 * @name AbstractPanel
 * @package Prime\Bootstrap\Panel
 * @create 03/04/2014
 * @access public
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
abstract class AbstractPanel extends View implements IDialog {

    private $footer;
    protected $message;
    protected $title;
    protected $id;
    protected $panel;
    protected $width = '480px';
    protected $style;

    public function __construct($message, $title = 'INFORMATIVO') {
        $this->id = 'panel_' . uniqid();
        $this->message = $message;
        $this->title = $title;
        $this->footer = array();
        $this->panel = new HTMLDiv($this->id);
        $this->panel->addClass('panel center-block');
        $this->panel->setStyle('margin-top', '10%');
    }

    /**
     * Define o Estilo para o Panel, aceitando os seguites valores:<br/>
     * PRIMARY, SUCCESS, INFO, WARNING, DANGER
     * @param string $style
     */
    public function setStyle($style) {
        $this->style = $style;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setModal($modal = TRUE) {
        $this->modal = TRUE;
    }

    private function createHeader() {
        $div = new HTMLDiv();
        $div->addClass('panel-heading');
        $h = new HTMLHeader(3);
        $h->addClass('panel-title');
        $h->appendChild($this->title);
        $div->appendChild($h);
        return $div;
    }

    private function createBody() {
        $div = new HTMLDiv();
        $div->addClass('panel-body');
        $div->appendChild($this->message);
        $div->appendChild($this->getContents());
        return $div;
    }

    private function createFooter() {
        $div = new HTMLDiv();
        $div->addClass('panel-footer text-right');
        foreach ($this->footer as $value) {
            $div->appendChild($value);
        }
        return $div;
    }

    public function setIdPanel($id) {
        $this->id = $id;
    }

    public function addButton($button) {
        $this->footer[] = $button;
    }

    /**
     * Retorna uma div modal
     * @return \Prime\Html\Base\HTMLDiv
     */
    private function getModalDiv() {
        $div = new HTMLDiv();
        $div->addClass('modal fade in');
        $div->setStyle('background-color', 'rgba(0, 0, 0, 0.5)');
        $div->setStyle('display', 'block');
        return $div;
    }

    public function getOutput() {
        $this->panel->appendChild($this->createHeader());
        $this->panel->appendChild($this->createBody());
        $this->panel->setStyle('width', $this->width);
        $this->panel->setStyle('max-width', '100%');
        $this->panel->addClass('panel-' . $this->style);

        if (count($this->footer)) {
            $this->panel->appendChild($this->createFooter());
        }

        $div = $this->getModalDiv();
        $div->appendChild($this->panel);
        $div->setAttribute('conection', $this->id);
        return $div->getOutput();
    }

}
