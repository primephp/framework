<?php

namespace Prime\Bootstrap\Media;

use Prime\Html\Base\HTMLDiv,
    Prime\View\IView;

/**
 * Descrição de Media
 * @name Media
 * @package Prime\Bootstrap\Media
 * @create 11/04/2014
 * @access public
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
class Media extends HTMLDiv {

    private $text = array();
    private $image;
    private $heading;

    /**
     * Estilos de objetos HTML abstratos para a construção de vários tipos de 
     * componentes (como comentários em blogs, tweets, etc) que apresentam uma 
     * esquerda ou imagem alinhado à direita ao lado de conteúdo textual.
     * @param string $nameId O ID da DIV container
     */
    public function __construct($nameId = null) {
        parent::__construct($nameId);
        parent::addClass('media');
    }

    /**
     * Adiciona text ou objetos html dentro do media
     * @param mixed $text
     */
    public function addText($text) {
        $this->text[] = $text;
    }

    protected function getText() {
        $text = '';
        foreach ($this->text as $value) {
            if ($value instanceof IView) {
                $text .= $value->getOutput();
            } else {
                $text .= (string) $value;
            }
        }
        return $text;
    }

    /**
     * Define a image a ser utilizada na Media
     * @param string $src
     * @param string $size
     * @return MediaImage Que deverá ser devidamente configurada
     */
    public function setImage($src, $size = 'cover') {
        $this->image = new MediaImage($src, $size);
        return $this->image;
    }

    public function getImage() {
        if ($this->image) {
            return $this->image->getOutput();
        }
    }

    /**
     * Define o texto a ser utilizado como cabeçalho do Media
     * @param IView $text
     */
    public function setHeading($text) {
        if ($text instanceof IView) {
            $this->heading = $text->getOutput();
        } else {
            $this->heading = (string) $text;
        }
    }

    private function getBody() {
        $body = new MediaBody();
        $body->setHeading($this->heading);
        $body->appendChild($this->getText());
        $body->appendChild($this->getChildren());
        return $body->getOutput();
    }

    /**
     * Retorna uma string representando todo o conteúdo HTML formando o objeto
     * media
     * @return string
     */
    public function getOutput() {
        $out = $this->openTag();
        $out .= $this->getImage();
        $out .= $this->getBody();
        $out .= $this->closeTag();

        return $out;
    }

}
