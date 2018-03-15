<?php

namespace Prime\Server\Http;

use Prime\View\ViewInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

/**
 * @name Response
 * @package Prime\Server\Http
 * @author Elton Luiz
 *        
 */
class Response extends BaseResponse
{

    public function __construct($content = '', $status = 200, $headers = [])
    {
        if ($content instanceof ViewInterface) {
            $content = $content->getOutput();
        }
        parent::__construct($content, $status, $headers);
    }

    public static function redirect($url)
    {
        return new RedirectResponse($url);
    }

}
