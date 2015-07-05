<?php

namespace Prime\Html\Dialog;

use App\Config\AppConfig,
    Prime\Html\Base\HTMLImage;

class HTMLDialogError extends HTMLDialog {

    //instancia uma nova linha
    public function __construct($message, $title = "INFORMATIVO", $width = 360, $height = 180) {
        parent::__construct($message, $title, $width, $height);
        $errorPicture = new HTMLImage(AppConfig::baseIcons() . "dialog-error-48.png");
        $this->dialog->setPosition(50, 50);
        $buttTop = $this->panel->getHeight() - 30;
        $buttLeft = $this->panel->getWidth() - 100;
        //$this->btnCancel->src = parent::ICON_PATH."/icons/button-cancel-light.png";
        $this->panel->appendChild($this->btnCancel, $buttTop, $buttLeft);
        $this->panel->appendChild($errorPicture, 25, 15);
        $this->dialog->appendChild($this->panel);
    }

}

