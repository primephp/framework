<?php

namespace Prime\Html\Base;

/**
 * Descrição de HTMLObject
 * @name HTMLObject
 * @package HTMLObject
 * @subpackage HTMLObject
 * @version 1.0
 * @since 21/06/2012
 * @access public
 * @author tom
 */
class HTMLObject extends HTMLElement {

    private $filename, $width, $height;
    private $autostart = 1;

    public function __construct($filename, $width = '400', $height = '300') {
        $this->filename = $filename;
        if (file_exists('.' . $this->filename)) {
            parent::__construct('object');

//            $this->setAttribute('src', $filename);
//            $finfo = finfo_open(FILEINFO_MIME_TYPE);
//            $this->type = finfo_file($finfo, '.' . $filename);
//            $this->setAttribute('codetype', $this->type);
        }
        $this->width = $width;
        $this->height = $height;
        $this->setAttribute('width', $this->width);
        $this->setAttribute('height', $this->height);
    }

    public
            function getOutput() {
        $this->setAttribute('data', $this->filename);

        $url = new HTMLElement('param');
        $url->setAttribute('name', 'src');
        $url->setAttribute('value', $this->filename);
        $this->appendChild($url);

        $url = new HTMLElement('param');
        $url->setAttribute('name', 'url');
        $url->setAttribute('value', $this->filename);
        $this->appendChild($url);

        $url = new HTMLElement('param');
        $url->setAttribute('name', 'autoplay');
        $url->setAttribute('value', $this->autostart);
        $this->appendChild($url);

        $color = new HTMLElement('param');
        $color->setAttribute('name', 'color');
        $color->setAttribute('value', '#FFFFFF');
        $this->appendChild($color);

        return parent::getOutput();
    }

}


