<?php

namespace Prime\Server\Http\Interfaces;

/**
 * Descrição de IHttpMessage
 * @package Prime\Server\Http\Interfaces
 * @create 26/03/2014
 * @author tom
 */
interface IHttpMessage {
    const TYPE_ERROR = 'error';
    const TYPE_WARNING = 'warning';
    const TYPE_INFO = 'info';
    const TYPE_SUCESS = 'sucess';
}
