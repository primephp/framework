<?php

namespace Prime\Html\Base;

/**
 * Classe para a exibicao de imagem
 * @author gedal
 */
class HTMLImage extends HTMLElement {

    private $info = array();
    private $height = NULL;
    private $width = NULL;

    /**
     * instancia o objet HTMLImage;
     *
     * @param string $src = localizacao da imagem a partir da raiz do site.;
     */
    public function __construct($src) {
        parent::__construct("img");

        $file = PUBLIC_PATH . $src;

        if (file_exists($file)) {
            $this->info = getimagesize($file);
            $this->setAttribute('width', $this->info[0]);
            $this->setAttribute('height', $this->info[1]);
        }
        $this->src = $src;
        $this->border = '0';
    }

    public function setAlt($text) {
        $this->setAttribute("alt", $text);
    }

    public function setWidth($width) {
        $this->setAttribute('width', $width);
    }

    public function getWidth() {
        if (isset($this->info[0])) {
            return $this->info[0];
        }
    }

    public function setHeight($height) {
        $this->setAttribute('height', $height);
    }

    public function getHeight() {
        if (isset($this->info[1])) {
            return $this->info[1];
        }
    }

    public function setMaximumSize($height, $width) {
        $novaLargura = (int) $width;
        $novaAltura = (int) $height;
        if ($this->getAttribute('height') > $height || $this->getAttribute('width') > $width) {
            // verifica se a largura é maior que a altura
            if ($this->getAttribute('height') > $this->getAttribute('width')) {
                $width = round(($novaLargura / $this->getAttribute('height')) * $this->getAttribute('width'));
                $this->setAttribute('height', $height);
                $this->setAttribute('width', $width);
            }
            // se a altura for maior que a largura
            elseif ($this->getAttribute('width') > $this->getAttribute('height')) {
                $height = round(($novaAltura / $this->getAttribute('width')) * $this->getAttribute('height'));
                $this->setAttribute('width', $width);
                $this->setAttribute('height', $height);
            }
            // altura == largura
            else {
                $this->setAttribute('height', $novaAltura);
                $this->setAttribute('width', $novaLargura);
            }
        }
    }

    public function setMaximumHeight($height) {
        if ($this->getAttribute('height') > $height) {
            $width = round(($height / $this->getAttribute('height')) * $this->getAttribute('width'));
            $this->setAttribute('height', $height);
            $this->setAttribute('width', $width);
        }
    }

    public function setMaximumWidth($width) {
        if ($this->getAttribute('width') > $width) {
            $height = round(($width / $this->getAttribute('width')) * $this->getAttribute('height'));
            $this->setAttribute('width', $width);
            $this->setAttribute('height', $height);
        }
    }

}

