<?php

namespace Prime\Bootstrap\Alert;

use Prime\Html\Base\HTMLDiv;
use Prime\Html\Base\HTMLElement;
use Prime\Html\Base\HTMLHeader;
use Prime\View\View;

/**
 * Descrição de AlertWidget
 * @name AlertWidget
 * @package Prime\Bootstrap\Alert;
 * @version 1.0
 * @create 17/12/2014
 * @access public
 * @author tom
 */
abstract class AlertAbstract extends View {

    /**
     *
     * @var string Tipo do Alert
     */
    protected $type;
    protected $dismissable = FALSE;
    protected $bolder = 'Atenção';

    public function __construct($type) {
        $this->type = $type;
    }

    public function hasDismissable() {
        $this->dismissable = TRUE;
    }

    protected function getIcon() {
        $i = new HTMLElement('i');
        $i->appendChild('');
        $i->addClass('fa fa-' . $this->type);
        
        $h4 = new HTMLHeader(4);
        $h4->appendChild($i);
        $h4->appendChild(' '.$this->getTipo());
        return $h4->getOutput();
    }

    protected function getCloseButton() {
        if ($this->dismissable) {
            $this->addClass('alert-dismissable');
            $button = new HTMLElement('button');
            $button->addClass('close');
            $button->setAttribute('aria-hidden', 'true');
            $button->setAttribute('data-dismiss', 'alert');
            $button->setAttribute('type', 'button');
            $button->appendChild('×');
            return $button->getOutput();
        }
    }

    
    protected function getTipo(){
        switch ($this->type) {
            case 'alert':
                $tipo = ' Alerta';
                break;
            case 'warning':
                $tipo = ' Cuidado';
                break;
            case 'success':
                $tipo = ' Informação';
                break;
            case 'info':
                $tipo = ' Informação';
                break;
            default:
                $tipo = ' Informação';
                break;
        }
        return $tipo;
    }

    public function getOutput() {
        $div = new HTMLDiv();
        $div->appendChild($this->getIcon());
        $div->appendChild($this->getCloseButton());
        $div->appendChild(parent::getContents());
        $div->addClass('alert');
        $div->addClass('alert-' . $this->type);
        if ($this->dismissable) {
            $div->addClass('alert-dismissable');
        }
        return $div->getOutput();
    }

}
