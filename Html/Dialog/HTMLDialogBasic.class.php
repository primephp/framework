<?php

namespace Prime\Html\Dialog;

use App\Config\AppConfig,
    Prime\Html\Base\HTMLImage;

class HTMLDialogBasic extends HTMLDialog {

//instancia uma nova linha
    public function __construct($message, $title = "INFORMATIVO.", $width = 360, $height = 180) {
        parent::__construct($message, $title, $width, $height);
        $info = new HTMLImage(AppConfig::baseIcons() . "web-basic.png");
        $this->dialog->setPosition(0, 0);
        //$buttTop= $this->panel->getHeight()-30;
        //$buttLeft = $this->panel->getWidth()-10;
        $windowId = $this->dialog->getWindowId();
        $this->btnConfirm->onclick = "p=document.getElementById('$windowId');(p.parentNode.removeChild(p));";
        $this->panel->appendChild($info, 20, 10);
        $this->dialog->appendChild($this->panel);
    }

}

