<?php

namespace Prime\Html\Base;

class HTMLHead extends HTMLElement
{

    //configuracao interna de dados

    public function __construct()
    {
        parent::__construct("head");
        $this->appendChild("");
    }

}
