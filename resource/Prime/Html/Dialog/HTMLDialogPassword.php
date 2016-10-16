<?php

namespace Prime\Html\Dialog;

use App\Config\AppConfig,
    Prime\Html\Base\HTMLElement,
    Prime\Html\Base\HTMLImage,
    Prime\Html\Input\HTMLInputHidden,
    Prime\Html\Input\HTMLInputPassword,
    Prime\Html\Input\HTMLInputText,
    Prime\Html\Table\HTMLTable;

class HTMLDialogPassword extends HTMLDialog {

    private $form;
    private $tblLogin;
    private static $icon;

    //instancia uma nova linha
    public function __construct($message = "", $title = "Login...",
            $width = 360, $height = 180) {
        parent::__construct($message, $title, $width, $height);
        $this->dialog->setPosition(150, 150);
        self::$icon = new HTMLImage(AppConfig::baseIcons() . "dialog-password.png");
        $this->form = new HTMLElement("form");
        $this->tblLogin = new HTMLTable();

        $txtLogin = new HTMLInputText("login");
        $txtPasswd = new HTMLInputPassword("passwd");
        $hiddenFrom = new HTMLInputHidden("fromPage");

        $this->form->name = "fLogin";
        $this->form->id = "fLogin";
        $this->form->method = "post";
        $this->form->enctype = "multipart/form-data";
        $this->form->action = "../processa/";

        $hiddenFrom->setValue("clogin");
        //----------------------------------------
        $nameRow = $this->tblLogin->insertRow();
        $nameCol = $nameRow->insertCell("Usuário: ");
        $userCol = $nameRow->insertCell($txtLogin);
        $userCol->colspan = "2";
        //----------------------------------------
        $loginRow = $this->tblLogin->insertRow();
        $loginCol = $loginRow->insertCell("Senha:");
        $loginCol = $loginRow->insertCell($txtPasswd);
        $loginCol->colspan = "2";
        //----------------------------------------
        $btnRow = $this->tblLogin->insertRow();
        $hidCol = $btnRow->insertCell("");
        $cfmCol = $btnRow->insertCell($this->btnConfirm);
        $cclCol = $btnRow->insertCell($this->btnCancel);

        $txtStyle = "font-size:12px;border:1px solid #ADBCC7;color:#6893C3;background:#ffffff;width:100%";
        $viewCss = "color:#4F576C;font-family:Sans Serif;font-size:12px;width:100%;";
        $txtLogin->addCSSStyle($txtStyle);
        $txtPasswd->addCSSStyle($txtStyle);
        $this->tblLogin->style = $viewCss;
        $this->tblLogin->cellspacing = "5";

        $cfmCol->style = "height:50px;vertical-align:bottom;text-align:left;width:90px;";
        $cclCol->style = "height:50px;vertical-align:bottom;text-align:right";
    }

    public function printOut() {
        $this->form->appendChild($this->tblLogin);
        $this->panel->appendChild($this->form, 60, 80);
        $this->panel->appendChild(self::$icon, 60, 15);
        $this->dialog->appendChild($this->panel);
        $this->dialog->printOut();
    }

    public function setId($fLogin) {
        $this->form->name = "$fLogin";
        $this->form->id = "$fLogin";
    }

    public function setMethod($method = "post") {
        $this->form->method = "$method";
    }

    public function setEncType($encType = "multipart/form-data") {
        $this->form->enctype = "$encType";
    }

    public function setAction($action = "../processa/") {
        $this->form->action = "$action";
    }

    public function addConfirmEvent($event, $handler) {
        $this->btnConfirm->$event = "$handler";
    }

}
