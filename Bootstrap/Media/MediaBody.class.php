<?php

namespace Prime\Bootstrap\Media;

use Prime\Html\Base\HTMLDiv;
use Prime\Html\Base\HTMLHeader;

/**
 * Descrição de MediaBody
 * @name MediaBody
 * @package Prime\Bootstrap\Media;
 * @date 11/04/2014
 * @access public
 * @author Tom Sailor <contato@eltonluiz.com.br>
 */
class MediaBody extends HTMLDiv {

    private $heading;

    public function __construct() {
        parent::__construct(NULL);
        parent::addClass('media-body');
    }

    private function getHeading() {
        $h = new HTMLHeader(4);
        $h->addClass('media-heading');
        $h->appendChild($this->heading);
        return $h->getOutput();
    }

    /**
     * Define o texto do cabeçalho do mediaBOdy
     * @param string $heading
     */
    public function setHeading($heading) {
        $this->heading = $heading;
    }
    
    public function getOutput() {
        $this->prependChild($this->getHeading());
        return parent::getOutput();
    }
}

?>
