<?php

namespace Prime\Bootstrap\Timeline;

use Prime\Html\Base\HTMLSpan;

/**
 * Descrição de TimelineLabel
 * @name TimelineLabel
 * @package Prime\Bootstrap\Timeline;
 * @version 1.0
 * @create 16/10/2014
 * @access public
 * @author tom
 */
class TimelineLabel extends TimelineAbstractItem {

    private $date;
    private $bgColor = 'bg-blue';

    public function __construct($date) {
        parent::__construct(NULL);
        $this->setDate($date);
        parent::addClass('time-label');
    }

    /**
     * Define a string de data
     * @param string $date
     */
    public function setDate($date) {
        $this->date = $date;
    }

    /**
     * Define a cor de fundo do Timeline label
     * @param string $color
     */
    public function setBgColor($color) {
        $this->bgColor = 'bg-' . $color;
    }

    /**
     * Retorna uma string de HTMLSpan
     * @param string $param
     * @return string
     */
    private function getDate() {
        $span = new HTMLSpan($this->date);
        $span->addClass($this->bgColor);
        return $span->getOutput();
    }
    
    public function getOutput() {
        $this->appendChild($this->getDate());
        return parent::getOutput();
    }

}
