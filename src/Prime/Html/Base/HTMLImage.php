<?php

namespace Prime\Html\Base;

/**
 * Classe para a exibicao de imagem
 * @author gedal
 */
class HTMLImage extends HTMLElement {

    private $info = [];
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
            $this->height = $this->info[1];
            $this->width = $this->info[0];
        }
        $this->src = $src;
        $this->border = '0';
    }

    public function setAlt($text) {
        $this->setAttribute("alt", $text);
    }

    /**
     * Define a largura da imagem
     * @param int $width
     */
    public function setWidth($width) {
        $this->setStyle('width', $width . 'px');
    }

    public function getWidth() {
        if (isset($this->info[0])) {
            return $this->info[0];
        }
    }

    /**
     * Define a altura da imagem
     * @param int $height
     */
    public function setHeight($height) {
        $this->setStyle('height', $height . 'px');
    }

    public function getHeight() {
        if (isset($this->info[1])) {
            return $this->info[1];
        }
    }

    public function setMaximumSize($height, $width) {
        $novaLargura = (int) $width;
        $novaAltura = (int) $height;
        if ($this->info[1] > $height || $this->info[0] > $width) {
            // verifica se a largura é maior que a altura
            if ($this->height > $this->width) {
                $width = round(($novaLargura / $this->height) * $this->width);
                $this->setHeight($height);
                $this->setWidth($width);
            }
            // se a altura for maior que a largura
            elseif ($this->width > $this->height) {
                $height = round(($novaAltura / $this->width) * $this->height);
                $this->setWidth($width);
                $this->setHeight($height);
            }
            // altura == largura
            else {
                $this->setHeight($novaAltura);
                $this->setWidth($novaLargura);
            }
        }
    }

    public function setMaximumHeight($height) {
        if ($this->height > $height) {
            $width = round(($height / $this->height) * $this->width);
            $this->setHeight($height);
            $this->setWidth($width);
        }
    }

    public function setMaximumWidth($width) {
        if ($this->width > $width) {
            $height = round(($width / $this->width) * $this->height);
            $this->setWidth($width);
            $this->setHeight($height);
        }
    }

}
