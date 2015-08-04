<?php

/*
 * The MIT License
 *
 * Copyright 2015 tom.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Prime\Server\Listener;

use Prime\View\Template;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Classe KernelExceptionListener <br>
 * 
 * @name KernelExceptionListener
 * @package Prime\Server\Listener
 * @author tom
 * @createAt 25/07/2015
 */
class KernelExceptionListener implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        return [
            KernelEvents::EXCEPTION => [
                ['onKernelException', 20]
            ]
        ];
    }

    public function onKernelException(GetResponseForExceptionEvent $event) {
        $exception = $event->getException();

        if ($exception instanceof UnauthorizedHttpException) {
            $template = new Template('@prime/401.twig');
            $event->setResponse(new Response($template->getOutput(), 401));
            
        } elseif ($exception instanceof AccessDeniedHttpException) {
            $template = new Template('@prime/403.twig');
            $event->setResponse(new Response($template->getOutput(), 403));
            
        } elseif ($exception instanceof NotFoundHttpException) {
            $template = new Template('@prime/404.twig');
            $event->setResponse(new Response($template->getOutput(), 404));
            
        } elseif ($exception instanceof ServiceUnavailableHttpException) {
            $template = new Template('@prime/503.twig');
            $event->setResponse(new Response($template->getOutput(), 503));
            
        } elseif ($exception instanceof HttpException) {
            $template = new Template('@prime/418.twig');
            $event->setResponse(new Response($template->getOutput(), 418));
            
        } else {
            $template = new Template('@prime/500.twig');
            $event->setResponse(new Response($template->getOutput(), 500));
        }
    }

}
