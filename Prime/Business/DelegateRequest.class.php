<?php

namespace Prime\Business;

use Prime\Http\Request,
    Prime\Http\Response;

/**
 * Descrição de DelegateRequest
 * @name DelegateRequest
 * @package Prime\Business
 * @version 1.0
 * @since 21/06/2012
 * @access public
 * @author tom
 */
abstract class DelegateRequest implements IDelegate {

    abstract protected function ajax();

    abstract protected function noAjax();

    public function delegate() {
        if (Request::isAjax()) {
            Response::printOut($this->ajax());
        } else {
            Response::printOut($this->noAjax());
        }
    }

}
