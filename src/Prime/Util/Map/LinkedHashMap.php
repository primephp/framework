<?php

/*
 * The MIT License
 *
 * Copyright 2016 85101346.
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

namespace Prime\Util\Map;

/**
 * Implementação de Map que estende HashMap, mas adiciona previsibilidade à 
 * ordem de iteração sobre os elementos, isto é, uma iteração sobre seus 
 * elementos (utilizando o Iterator) mantém a ordem de inserção (a inserção de 
 * elementos duplicados não altera a ordem anterior). Internamente, é mantida 
 * uma lista duplamente encadeada que mantém esta ordem. Por ter que manter uma 
 * lista paralelamente à tabela hash, a modificação deste tipo de coleção 
 * acarreta em uma leve queda na performance em relação à HashMap, mas ainda é 
 * mais rápida que uma TreeMap, que utiliza comparações para determinar a ordem 
 * dos elementos.
 *
 * @author TomSailor
 * @createAt 24/08/2016
 */
class LinkedHashMap extends HashMap {
    //put your code here
}
