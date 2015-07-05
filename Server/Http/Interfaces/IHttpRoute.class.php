<?php

namespace Prime\Server\Http\Interfaces;

/**
 *
 * @author TomSailor
 */
interface IHttpRoute {

    public function setRequest($url);

    public function getRequest();

    public function getQueryString();

    public function getParam($name);

    public function addParam($name, $value);
}
