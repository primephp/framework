<?php

namespace Prime\Util\Interfaces;

use Iterator;

/**
 * Descrição da Interface IIterator
 * @package Prime\util
 * @dateCreate 06/06/2014
 * @author comforsup-0215
 */
interface IIterator extends Iterator
{

    public function hasNext();

    public function remove();
}
