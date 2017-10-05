<?php

namespace Prime\Html\Dialog;

use App\Config\AppConfig,
    Prime\Config\IMouseEvent,
    Prime\Html\Base\HTMLImage;

class HTMLDialogQuestion extends HTMLDialog
{

    //instancia uma nova linha
    public function __construct($message, $title = "Solicitação.", $width = 360, $height = 180)
    {
        parent::__construct($message, $title, $width, $height);
        $this->dialog->setPosition(50, 50);
        $questionPicture = new HTMLImage(AppConfig::baseIcons() . "dialog-question-48.png");
        $buttTop = $this->panel->getHeight() - 30;
        $buttLeft = $this->panel->getWidth() - 100;
        $this->btnConfirm->src = AppConfig::baseIcons() . "button-ok-light.png";
        $windowId = $this->dialog->getWindowId();
        $this->btnConfirm->{IMouseEvent::CLICK} = "$('#$windowId').fadeOut('slow', function(){p=document.getElementById('$windowId');(p.parentNode.removeChild(p));});";
        $this->panel->appendChild($this->btnConfirm, $buttTop, $buttLeft - 110);
        $this->panel->appendChild($this->btnCancel, $buttTop, $buttLeft);
        $this->panel->appendChild($questionPicture, 25, 15);
        $this->dialog->appendChild($this->panel);
    }

    public function addConfirmEvent($event, $handler)
    {
        if ($this->btnConfirm->getAttribute($event)) {
            $onclick = $this->btnConfirm->getAttribute($event);
            $this->btnConfirm->{$event} = $onclick . $handler;
        } else {
            $this->btnConfirm->{$event} = $handler;
        }
    }

    public function addCancelEvent($event, $handler)
    {
        if ($this->btnCancel->getAttribute($event)) {
            $onclick = $this->btnCancel->getAttribute($event);
            $this->btnCancel->{$event} = $onclick . $handler;
        } else {
            $this->btnCancel->{$event} = $handler;
        }
    }

}
