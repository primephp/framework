<?php

namespace Prime\Html\Dialog;

use App\Config\AppConfig,
    Prime\Html\Base\HTMLImage;

class HTMLDialogDownload extends HTMLDialog {

//instancia uma nova linha
    public function __construct($message, $title = "INFORMATIVO.", $width = 360,
            $height = 180) {
        parent::__construct($message, $title, $width, $height);
        $info = new HTMLImage(AppConfig::baseIcons() . "dialog-download-48.png");
        $this->dialog->setPosition(0, 50);
        $buttTop = $this->panel->getHeight() - 30;
        $buttLeft = $this->panel->getWidth() - 100;
        $windowId = $this->dialog->getWindowId();
        $this->btnConfirm->onclick = "p=document.getElementById('$windowId');(p.parentNode.removeChild(p));";
        $this->panel->appendChild($info, 25, 15);
        $this->dialog->appendChild($this->panel);
    }

}
