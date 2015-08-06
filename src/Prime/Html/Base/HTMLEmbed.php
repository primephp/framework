<?php

namespace Prime\Html\Base;

/**
 * Descrição de HTMLEmbed
 * @name HTMLEmbed
 * @package HTMLEmbed
 * @subpackage HTMLEmbed
 * @version 1.0
 * @since 21/06/2012
 * @access public
 * @author tom
 */
class HTMLEmbed extends HTMLElement
{

    private $type;

    public function __construct($filename)
    {
        parent::__construct('embed');

        $this->setAttribute('src', $filename);
    }

    public function getMimeType()
    {
        return $this->type;
    }

}
