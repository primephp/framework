<?php

/*
 * The MIT License
 *
 * Copyright 2015 Elton Luiz.
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

namespace Prime\EventDispatcher;

use Prime\Core\TObject;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Descrição da Classe AbstractListener
 *
 * @name AbstractListener
 * @package Prime\EventDispatcher
 * @createAt 03/08/2015
 * @author Elton Luiz
 */
abstract class AbstractListener extends TObject
        implements EventSubscriberInterface {

    /**
     * @TODO
     * getSubscribedEvents() deverá retornar de forma mais elegante os eventos
     * inscritos, podendo ser adicionados de forma mais elegantes para que não
     * se retorne grosseiramente um ARRAY de eventos e seus métodos que devem 
     * ser invodos
     * 
     */
    public static function getSubscribedEvents() {
        
    }

}
