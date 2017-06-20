<?php

namespace Prime\Html\Dialog;

use App\Config\AppConfig,
    Prime\Config\IMouseEvent,
    Prime\Html\Base\HTMLElement,
    Prime\Html\Base\HTMLParagraph;

abstract class HTMLDialog {

    protected $dialog;
    protected $btnConfirm;
    protected $btnCancel;
    protected $btnOk;
    protected $panel;

    //instancia uma nova linha
    public function __construct($message, $title = "", $width = 360,
            $height = 180) {
        //Um HTMLWindow para posicionar os obetos na tela
        //mudancas na aprencia de HTMLWindow tambem deve ser realizada em HTMLPanel
        $this->dialog = new HTMLWindow("$title", $width, $height);
        $windowId = $this->dialog->getWindowId();
        $this->dialog->setPosition("40%", "40%");
        //um painel HTMLPanel para dispor os objetos em HTMLWindow
        $panelWidth = $this->dialog->getWidth() - 15;
        $panelHeight = $this->dialog->getHeight() - 2;
        $this->panel = new HTMLPanel($panelWidth, $panelHeight);
        $this->panel->backgroundColor = "#FAFAFB";
        //$this->panel->padding = '5px';
        //CRIA OS BOTÕES PADRÕES DOS DIALOGS
        $this->btnConfirm = new HTMLElement('input');
        $this->btnConfirm->type = 'image';
        $this->btnConfirm->src = AppConfig::baseIcons() . 'button-ok-light.png';
        $this->btnConfirm->value = "Confirmar";
        $this->btnConfirm->style = 'border:0px;';
        $this->btnConfirm->title = 'Fechar Caixa de Diálogo.';

        $this->btnOk = new HTMLElement('input');
        $this->btnOk->type = 'image';
        $this->btnOk->src = AppConfig::baseIcons() . 'button-exit-light.png';
        $this->btnOk->{IMouseEvent::CLICK} = "$('#$windowId').fadeOut('slow', function(){p=document.getElementById('$windowId');(p.parentNode.removeChild(p));});";
        $this->btnOk->value = 'Sair';
        $this->btnOk->style = 'border:0px;';
        $this->btnOk->title = 'Fechar Caixa de Diálogo.';

        $this->btnCancel = new HTMLElement("input");
        $this->btnCancel->type = 'image';
        $this->btnCancel->src = AppConfig::baseIcons() . 'button-cancel-light.png';
        $this->btnCancel->{IMouseEvent::CLICK} = "$('#$windowId').fadeOut('slow', function(){p=document.getElementById('$windowId');(p.parentNode.removeChild(p));});";
        $this->btnCancel->value = 'Cancelar';
        $this->btnCancel->style = 'border:0px;';


        $msgParagraph = new HTMLParagraph($message);
        $msgParagraph->style = "font-family:Sans Serif;font-size:12px; padding-right: 10px; text-align:justify; ";
        $this->panel->appendChild($msgParagraph, 0, 80);
    }

    /**
     * Altera a posição do Dialog a ser apresentado na tela.
     * Quando usado com ajax, deve criar metodos de javascript
     * para apresentar corretamente na tela.
     *
     * @param integer $top
     * @param integer $left
     */
    public function setPosition($top, $left) {
        $this->dialog->setPosition($top, $left);
    }

    /**
     * Deve ser usada para informar que evento javascript
     * desencadeará uma ação de confirmação no DialogBox;
     *
     * @param string $event
     * @param string $handler
     */
    public function addConfirmEvent($event, $handler) {
        
    }

    /**
     * Deve ser usada para informa que evento javascript
     * desencadeará para cancelar uma ação no DialogBox;
     *
     * @param string $event
     * @param string $handler
     */
    public function addCancelEvent($event, $handler) {
        if ($this->btnCancel->getAttribute($event)) {
            $onclick = $this->btnCancel->getAttribute($event);
            $this->btnCancel->{$event} = $onclick . $handler;
        } else {
            $this->btnCancel->{$event} = $handler;
        }
    }

    /**
     * imprime a caixa de diálogo na tela do navegador
     *
     * @return void
     */
    public function printOut() {
        $this->dialog->printOut();
    }

    /**
     * imprime a caixa de diálogo na tela do navegador
     *
     * @return void
     */
    public function getOutput() {
        $this->dialog->appendChild($this->panel);
        return $this->dialog->getOutput();
    }

    /**
     * A identificação da caixa de diálogo sendo processada no momento.
     * @return string
     */
    public function getDialogId() {
        return $this->dialog->getWindowId();
    }

    public function zIndex($value) {
        $this->dialog->zIndex($value);
    }

}
