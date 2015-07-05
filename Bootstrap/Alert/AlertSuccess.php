<?php

namespace Prime\Bootstrap\Alert;

use Prime\Html\Base\HTMLElement;

/**
 * Descrição de AlertSuccess
 * @name AlertSuccess
 * @package Prime\Bootstrap\Alert;
 * @version 1.0
 * @create 17/12/2014
 * @access public
 * @author tom
 */
class AlertSuccess extends AlertAbstract {

    public function __construct($id = NULL) {
        parent::__construct('success');
        if (!is_null($id)) {
            $this->setAttribute('id', $id);
        }
    }

    protected function getIcon() {
        $i = new HTMLElement('i');
        $i->appendChild('');
        $i->addClass('fa fa-check');
        return $i->getOutput();
    }

}
