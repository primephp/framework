<?php

namespace Prime\Bootstrap\Form;

use Prime\Html\Base\HTMLDiv;

/**
 * Descrição de FormGroup
 * @package Prime\Bootstrap\Form
 * @create 24/03/2014
 * @author tom
 */
class FormGroup extends HTMLDiv{
    public function __construct($nameId = null) {
        parent::__construct($nameId);
        parent::addClass('form-group');
    }
}
