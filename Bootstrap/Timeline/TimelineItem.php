<?php

namespace Prime\Bootstrap\Timeline;

use Prime\Html\Base\HTMLDiv;
use Prime\Html\Base\HTMLElement;
use Prime\Html\Base\HTMLHeader;
use Prime\Html\Base\HTMLSpan;

/**
 * Descrição de TimelineItem
 * @name TimelineItem
 * @package Prime\Bootstrap\Timeline;
 * @version 1.0
 * @create 16/10/2014
 * @access public
 * @author tom
 */
class TimelineItem extends TimelineAbstractItem {

    private $icon;
    private $hour;
    private $title;
    private $footer = array();

    /**
     *
     * @var HTMLDiv 
     */
    private $body;

    public function __construct($id = NULL) {
        parent::__construct($id);
        $this->body = new HTMLDiv();
        $this->body->addClass('timeline-body');
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setHour($hour) {
        $this->hour = $hour;
    }

    public function setIcon($icon, $bgColor = NULL) {
        $this->icon = array('icon' => $icon, 'bgcolor' => $bgColor);
    }

    public function addFooterItem(HTMLElement $item) {
        $this->footer[] = $item;
    }

    /**
     * 
     * @return HTMLHeader
     */
    private function getTitle() {
        $h = new HTMLHeader(3);
        $h->addClass('timeline-header');
        $h->appendChild($this->title);
        return $h;
    }

    /**
     * 
     * @return HTMLSpan
     */
    private function getHour() {
        $span = new HTMLSpan();
        $span->addClass('time');
        $i = new HTMLElement('i');
        $i->addClass('fa fa-clock-o');
        $span->appendChild($i);
        $span->appendChild(date('H:i', strtotime(str_replace('/', '-', $this->hour))));
        return $span;
    }

    private function getIcon() {
        $i = new HTMLElement('i');
        if (isset($this->icon['icon'])) {
            $i->addClass($this->icon['icon']);
        }
        if (isset($this->icon['bgcolor'])) {
            $i->addClass('bg-' . $this->icon['bgcolor']);
        }
        return $i;
    }

    /**
     * 
     * @return HTMLDiv | NULL
     */
    private function getFooter() {
        if (count($this->footer)) {
            $div = new HTMLDiv();
            $div->addClass('timeline-footer');

            foreach ($this->footer as $item) {
                $div->appendChild($item);
            }
            return $div;
        }
        return NULL;
    }

    private function getTimelineDiv() {
        $div = new HTMLDiv();
        $div->addClass('timeline-item');
        $div->appendChild($this->getHour());
        $div->appendChild($this->getTitle());
        $div->appendChild($this->body);
        $div->appendChild($this->getFooter());
        return $div;
    }

    public function appendChild($child) {
        $this->body->appendChild($child);
    }

    public function getOutput() {
        parent::appendChild($this->getIcon());
        parent::appendChild($this->getTimelineDiv());
        return parent::getOutput();
    }

}
