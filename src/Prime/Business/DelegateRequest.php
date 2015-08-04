<?php

namespace Prime\Business;

use Prime\Server\Http\Request,
    Prime\Server\Http\Response,
    Prime\Server\Http\Router,
    Prime\Server\Http\Url;

/**
 * Descrição de DelegateRequest
 * @name DelegateRequest
 * @package Prime\Business
 * @version 1.0
 * @since 21/06/2012
 * @access public
 * @author tom
 */
abstract class DelegateRequest implements DelegateInterface {

    abstract protected function ajax();

    abstract protected function noAjax();

    public function delegate() {
        if (Request::isAjax()) {
            Response::printOut($this->ajax());
        } else {
            Response::printOut($this->noAjax());
        }
    }
    
    protected function changeRouter(Url $url) {
        Router::redirect($url);
    }

}
