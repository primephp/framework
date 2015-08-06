<?php

namespace Prime\Html\Dialog;

use App\Config\AppConfig,
    Prime\Config\IMouseEvent,
    Prime\Html\Base\HTMLImage;

class HTMLDialogInformation extends HTMLDialog
{

    /**
     * Cria uma caixa de diálogo de informação
     * @param string $message Mensagem a ser exibida
     * @param string $title título da caixa de diálogo
     * @param int $width Largura da caixa de diálogo
     * @param int $height Altura da caixa de diálogo
     */
    public function __construct($message, $title = "INFORMAÇÃO", $width = 360, $height = 180)
    {
        parent::__construct($message, $title, $width, $height);
        $info = new HTMLImage(AppConfig::baseIcons() . "dialog-information-48.png");
        $this->dialog->setPosition(50, 50);
        $buttTop = $this->panel->getHeight() - 30;
        $buttLeft = $this->panel->getWidth() - 100;

        $windowId = $this->dialog->getWindowId();
        $this->btnOk->{IMouseEvent::CLICK} = "$('#$windowId').fadeOut('slow', function(){p=document.getElementById('$windowId');(p.parentNode.removeChild(p));});";
        $this->panel->appendChild($this->btnOk, $buttTop, $buttLeft);
        $this->panel->appendChild($info, 25, 15);
        $this->dialog->appendChild($this->panel);
    }

    /**
     * Adiciona um evento ao clicar em Ok
     * @param type $event
     * @param type $handler 
     */
    public function addConfirmEvent($event, $handler)
    {
        if ($this->btnOk->getAttribute($event)) {
            $onclick = $this->btnOk->getAttribute($event);
            $this->btnOk->{$event} = $onclick . $handler;
        } else {
            $this->btnOk->{$event} = $handler;
        }
    }

    /**
     * Não Utilizável neste Escopo
     * @param type $event
     * @param type $handler 
     */
    public function addCancelEvent($event, $handler)
    {
        trigger_error("Classe: " . __CLASS__ . " Método: " . __METHOD__ . " não utilizável neste escopo.", E_USER_WARNING);
    }

}
