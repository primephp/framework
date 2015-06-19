<?php

namespace Prime\Html\Dialog;

use App\Config\AppConfig,
    Prime\Html\Base\HTMLImage,
    Prime\Widgets\Calendar;

class HTMLDialogCalendar extends HTMLDialog {

    //instancia uma nova linha
    public function __construct($year = null, $month = null, $width = 360, $height = 180) {
        parent::__construct("", "Calendário...", $width, $height);
        $calendar = new Calendar($year, $month);
        $errorPicture = new HTMLImage(AppConfig::baseIcons() . "calendar.png");
        $this->dialog->setPosition(150, 150);
        $buttTop = $this->panel->getHeight() - 30;
        $buttLeft = $this->panel->getWidth() - 100;
        $this->panel->appendChild($calendar->getMonth(), 0, 100);
        $this->panel->appendChild($this->btnConfirm, $buttTop, $buttLeft);
        $this->panel->appendChild($errorPicture, 25, 15);
        $this->dialog->appendChild($this->panel);
    }

}

