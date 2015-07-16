<?php

namespace Prime\Bootstrap\Panel;

use Prime\Config\IMouseEvent,
    Prime\Html\Base\HTMLElement;

/**
 * Descrição de DialogInformation
 * @name DialogInformation
 * @package Prime\Bootstrap\Panel
 * @create 03/04/2014
 * @access public
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
class DialogInformation extends AbstractPanel {

    /**
     *
     * @var HTMLElement 
     */
    protected $btnOk;
    
    protected $btnOkText = 'OK';

    public function __construct($message, $title = 'INFORMATIVO') {
        parent::__construct($message, $title);
        $this->setStyle('info');
        $this->createButton();
    }

    private function createButton() {
        $this->btnOk = new HTMLElement('button');
        $this->btnOk->setAttribute('type', 'button');
        $this->btnOk->addClass('btn btn-primary');
        $this->btnOk->appendChild($this->btnOkText);
        $this->btnOk->setAttribute(IMouseEvent::CLICK, "$('#{$this->id}').hide('500',function(){\$(this).remove();\$('div[conection=\'$this->id\']').remove();});");
        $this->addButton($this->btnOk);
    }

    public function addConfirmEvent($event, $handler) {
        $this->AddButtonEvent($event, $handler);
    }
    
    public function setButtonConfirmText($text){
        $this->btnOkText = $text;
    }

    public function AddButtonEvent($event, $handler) {
        if ($this->btnOk->getAttribute($event)) {
            $onclick = $this->btnOk->getAttribute($event);
            $this->btnOk->{$event} = $onclick . $handler;
        } else {
            $this->btnOk->{$event} = $handler;
        }
    }

}
