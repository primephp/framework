<?php

namespace Prime\Bootstrap\Panel;

use Prime\Config\IMouseEvent,
    Prime\Html\Base\HTMLElement;

/**
 * Descrição de DialogQuestion
 * @name DialogQuestion
 * @package Prime\Bootstrap\Panel
 * @create 04/04/2014
 * @access public
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
class DialogQuestion extends AbstractPanel {

    /**
     *
     * @var HTMLElement 
     */
    protected $btnConfirm;

    /**
     *
     * @var HTMLElement 
     */
    protected $btnCancel;

    public function __construct($message, $title = 'CONFIRMAÇÃO') {
        parent::__construct($message, $title);
        $this->setStyle('info');
        $this->createButton();
    }

    private function createButton() {
        $this->btnConfirm = new HTMLElement('button');
        $this->btnConfirm->setAttribute('type', 'button');
        $this->btnConfirm->addClass('btn btn-success');
        $this->btnConfirm->appendChild('Confirmar');
        $this->btnConfirm->setAttribute(IMouseEvent::CLICK, "$('#{$this->id}').hide('500',function(){\$(this).remove();\$('div[conection=\'$this->id\']').remove();});");
        $this->addButton($this->btnConfirm);

        $this->btnCancel = new HTMLElement('button');
        $this->btnCancel->setAttribute('type', 'button');
        $this->btnCancel->addClass('btn btn-danger');
        $this->btnCancel->appendChild('Cancelar');
        $this->btnCancel->setAttribute(IMouseEvent::CLICK, "$('#{$this->id}').hide('500',function(){\$(this).remove();\$('div[conection=\'$this->id\']').remove();});");
        $this->addButton($this->btnCancel);

        $this->panel->addClass('panel-warning');
    }

    public function addConfirmEvent($event, $handler) {
        if ($this->btnConfirm->getAttribute($event)) {
            $onclick = $this->btnConfirm->getAttribute($event);
            $this->btnConfirm->{$event} = $onclick . $handler;
        } else {
            $this->btnConfirm->{$event} = $handler;
        }
    }

    public function addCancelEvent($event, $handler) {
        if ($this->btnCancel->getAttribute($event)) {
            $onclick = $this->btnCancel->getAttribute($event);
            $this->btnCancel->{$event} = $onclick . $handler;
        } else {
            $this->btnCancel->{$event} = $handler;
        }
    }

}
