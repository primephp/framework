<?php

namespace Prime\Html\Input;

class HTMLInputFile extends HTMLInput {

    public function __construct($name) {
        parent::__construct();
        $this->element->name = $name;
        $this->element->id = $name;
        $this->element->type = 'file';
    }

    /**
     *
     * @param integer $maxFilesize
     */
    public function setMaxFilesize($maxFilesize = 1024) {
        $this->element->MAX_FILE_SIZE = $maxFilesize;
    }

    public function acceptImageFiles() {
        $this->element->accept = "image/gif, image/jpeg, image/png";
    }

    public function acceptPDFFiles() {
        $this->element->accept = "application/pdf";
    }

}
