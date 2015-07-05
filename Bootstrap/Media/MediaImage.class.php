<?php

namespace Prime\Bootstrap\Media;

use Prime\Html\Base\HTMLAnchor;
use Prime\Html\Base\HTMLDivImage;
use Prime\Html\Base\HTMLImage;
use Prime\Server\Http\Url;

/**
 * Descrição de MediaImage
 * @name MediaImage
 * @package Prime\Bootstrap\Media;
 * @date 12/04/2014
 * @access public
 * @author Tom Sailor <contato@eltonluiz.com.br>
 */
class MediaImage extends HTMLDivImage {

    private $align = 'left';
    private $href = '#';
    
    /**
     * Cria um objeto para ser introduzido em um html media
     * aceitando como parâmetro o SRC da imagem
     * @param string $src
     */
    public function __construct($src, $size) {
        parent::__construct($src, $size);
        $this->addClass('media-object');
    }

    /**
     * Define o alinhamento da imagem no objeto de media
     * @param string $align Aceita as opções de left | right
     */
    public function setAlign($align) {
        if (in_array($align, array('left', 'right'))) {
            $this->align = $align;
        }
    }

    /**
     * Define o HREF para linkar o objeto de imagem com um link
     * @param Url $href
     */
    public function setHref(Url $href) {
        $this->href = $href->getUrl();
    }

    private function getImage() {
        $a = new HTMLAnchor($this->href, $this->getImage());
        return $a;
    }
    
    public function getOutput() {
        $a = new HTMLAnchor($this->href, parent::getOutput());
        $a->setTitle($this->getAttribute('title'));
        $a->addClass('pull-'.$this->align);
        
        return $a->getOutput();
    }

}

?>
