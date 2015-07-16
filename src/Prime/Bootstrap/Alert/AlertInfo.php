<?php

namespace Prime\Bootstrap\Alert;

/**
 * Descrição de AlertInfo
 * @name AlertInfo
 * @package Prime\Bootstrap\Alert;
 * @version 1.0
 * @create 17/12/2014
 * @access public
 * @author tom
 */
class AlertInfo extends AlertAbstract {

    public function __construct($id = NULL) {
        parent::__construct('info');
        if (!is_null($id)) {
            $this->setAttribute('id', $id);
        }
    }

}
