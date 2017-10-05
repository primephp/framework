<?php

/*
 * The MIT License
 *
 * Copyright 2016 Tom Sailor.
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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Classe Tom Sailor <br>
 * Responsável por manipular a requisição
 * @name RequestListener
 * @package Prime\Server\Listener
 * @author Tom Sailor
 * @createAt 24/10/2016
 */
class RequestListener implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'createTokenId'
        ];
    }

    /**
     * Responsável por criar um TokenId para validação das requisições
     * do usuário
     * @param GetResponseEvent $event
     */
    public function createTokenId(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $session = $request->getSession();
        if (!$request->isXmlHttpRequest()) {
            $session->set('token.id', sha1(uniqid()));
            $session->save();
        }
    }

}
