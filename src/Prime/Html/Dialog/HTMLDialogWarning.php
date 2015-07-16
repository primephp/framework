<?php

namespace Prime\Html\Dialog;

use App\Config\AppConfig,
    Prime\Html\Base\HTMLImage;

class HTMLDialogWarning extends HTMLDialog {

//instancia uma nova linha
    public function __construct($message, $title = "ATENÇÃO", $width = 360, $height = 180) {
        parent::__construct($message, $title, $width, $height);
        $warningPicture = new HTMLImage(AppConfig::baseIcons() . "dialog-warning-48.png");
        $this->dialog->setPosition(50, 50);
        $buttTop = $this->panel->getHeight() - 30;
        $buttLeft = $this->panel->getWidth() - 100;
        $this->panel->appendChild($this->btnOk, $buttTop, $buttLeft);
        $this->panel->appendChild($warningPicture, 25, 25);
        $this->dialog->appendChild($this->panel);
    }

    /**
     * Adiciona um evento ao clicar em Ok
     * @param type $event
     * @param type $handler 
     */
    public function addConfirmEvent($event, $handler) {
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
    public function addCancelEvent($event, $handler) {
        trigger_error("Classe: " . __CLASS__ . " Método: " . __METHOD__ . " não utilizável neste escopo.", E_USER_WARNING);
    }

}
