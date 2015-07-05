<?php

namespace Prime\Bootstrap\Form;

/**
 * Descrição de InputText
 * @package Prime\Bootstrap\Form
 * @create 24/03/2014
 * @author tom
 */
class InputText extends Input {

    public function __construct($nameId) {
        parent::__construct();
        parent::setAttribute('id', $nameId);
        parent::setAttribute('name', $nameId);
        parent::setAttribute('type', 'text');
    }

}
