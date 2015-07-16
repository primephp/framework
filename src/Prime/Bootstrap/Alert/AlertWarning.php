<?php

namespace Prime\Bootstrap\Alert;

/**
 * Descrição de AlertWarning
 * @name AlertWarning
 * @package Prime\Bootstrap\Alert;
 * @version 1.0
 * @create 17/12/2014
 * @access public
 * @author tom
 */
class AlertWarning extends AlertAbstract {

    public function __construct($id = NULL) {
        parent::__construct('warning');
        if (!is_null($id)) {
            $this->setAttribute('id', $id);
        }
    }

}
