<?php

namespace Prime\Html\Base;

/**
 * Descrição de HTMLDivImage
 * @name HTMLDivImage
 * @package Prime\Html\Base
 * @version 1.0
 * @create 15/03/2014
 * @access public
 * @author Elton Luiz <www.eltonluiz@hotmail.com>
 */
class HTMLDivImage extends HTMLElement
{

    private $info;
    private $height;
    private $width;
    private $newHeight;
    private $newWidth;

    /**
     * instancia o objet HTMLDivImage;
     *
     * @param string $src = localizacao da imagem a partir da raiz do site.;
     * @param string $size Aceita a definição do background como COVER ou CONTAIN
     */
    public function __construct($src, $size = 'cover')
    {
        parent::__construct("div");

        $file = PUBLIC_PATH . $src;

        $this->setStyle('position', 'relative');
        $this->setStyle('background-image', "url('" . $src . "')");
        $this->setStyle('background-size', $size);
        $this->setStyle('background-repeat', 'no-repeat');
        $this->setStyle('background-position', 'center');

        if (file_exists($file)) {
            $this->info = getimagesize($file);
            $this->height = $this->info[1];
            $this->width = $this->info[0];
        }
    }

    public function setAlt($text)
    {
        $this->setAttribute("alt", $text);
    }

    public function setWidth($width)
    {
        $this->newWidth = $width;
    }

    public function getWidth()
    {
        if (isset($this->info[0])) {
            return $this->info[0];
        }
    }

    public function setHeight($height)
    {
        $this->newHeight = $height;
    }

    public function getHeight()
    {
        if (isset($this->info[1])) {
            return $this->info[1];
        }
    }

    public function setMaximumSize($height, $width)
    {
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

    public function getOutput()
    {
        if (empty($this->newHeight)) {
            $this->setStyle('height', $this->getHeight() . 'px');
        } else {
            $this->setStyle('height', $this->newHeight . 'px');
        }
        if (!empty($this->newWidth)) {
            $this->setStyle('width', $this->newWidth . 'px');
        }
        return parent::getOutput();
    }

}
