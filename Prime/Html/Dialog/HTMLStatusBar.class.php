<?php

namespace Prime\Html\Dialog;

use Prime\DataTypes\TDatetime,
    Prime\Html\Base\HTMLImage,
    Prime\Html\Style\HTMLStyle,
    Prime\Html\Table\HTMLTable,
    Prime\View\IView;

class HTMLStatusBar implements IView {

    private $container;
    private $items;
    private $rowItem;
    private $firstItem;
    private $icon;

    public function __construct($status = "") {
        $this->firstItem = "$status";
        if (empty($status)) {
            $date = new TDatetime();
            $this->firstItem = $date->getDatePTBR();
        }
        $this->items = array();
        $this->container = new HTMLTable();
        $this->container->border = "0";
        $this->container->width = "100%";
        $this->container->cellspacing = "1";
        $this->container->class = "statusBar";
    }

    /**
     * retorna um tabela previamente formatada
     *
     * @return HTMLTable
     */
    public function getStatusBar() {
        $this->createStatus();
        return $this->container;
    }

    public function addItem($item) {
        if (count($this->items) < 3) {
            $this->items[] = "$item";
        }
    }

    public function getOutput() {
        return $this->getStatusBar();
    }

    public function printOut() {
        $this->createStatus();
        $this->container->printOut();
    }

    public function setAttribute($name, $value) {
        $this->container->setAttribute($name, $value);
    }

    public function setStyle($property, $value) {
        $this->container->setStyle($property, $value);
    }

    /**
     *
     * @return  void
     */
    private function createStatus() {
        $this->rowItem = $this->container->insertRow();
        $firstCell = $this->rowItem->insertCell($this->firstItem);
        $firstCell->id = "status_0";
        $this->produceStatus();
        if ($this->icon) {
            $resizeIcon = new HTMLImage($this->icon);
            $resizeIcon->setMaximumSize(29, 29);
            $resizeCol = $this->rowItem->insertCell($resizeIcon);
            $resizeCol->style = "width:3%;text-align:right;";
        }
    }

    public function setIcon($src) {
        $this->icon = $src;
    }

    private function produceStatus() {
        $id = 1;
        foreach ($this->items as $item) {
            $itemCell = $this->rowItem->insertCell($item);
            $itemCell->style = "width:10%;text-align:right;";
            $itemCell->id = "status_" . $id;
            $itemCell->nowrap = "nowrap";
            $id++;
        }
    }

    private function createStatusLook() {
        $look = new HTMLStyle("statusBar");
        $look->font_size = "12px";
        $look->font_family = "Sans";
        $look->text_align = "left";
        $look->color = "#F3F5F5";
        $look->border = "1px outset #CEDAE8";
        $look->background_color = "#AABACC";
        //$look->background_image="url('../library/icons/grid_caption.png')";
        $look->printOut();
    }

}

