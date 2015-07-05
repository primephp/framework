<?php

namespace Prime\Html\Base;

abstract class HTMLCSS2 {

    protected $borderWidth;
    protected $width;
    protected $height;
    protected $borderColor;
    protected $borderStyle;
    protected $top;
    protected $left;
    // protected $backgroundColor;
    protected $fontSize;
    protected $fontFamily;

    public function setBorderWidth($borderWidth) {
        $this->borderWidth = $borderWidth;
    }

    public function setWidth($width) {
        $this->width = $width;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function setBorderColor($borderColor) {
        $this->borderColor = $borderColor;
    }

    public function setBorderStyle($borderStyle) {
        $this->boderS = $borderStyle;
    }

    public function setTop($top) {
        $this->top = $top;
    }

    public function setLeft($left) {
        $this->left = $left;
    }

    public function setBackgroundColor($bgColor) {
        $this->backgroundColor = $bgColor;
    }

    public function setFontFamily($ff) {
        $this->fontFamily = $ff;
    }

    public function setFontSize($fs) {
        $this->fontSize = $fs;
    }

    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }

}

