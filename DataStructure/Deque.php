<?php

/*
 * The MIT License
 *
 * Copyright 2017 TomSailor.
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

namespace Prime\DataStructure;

/**
 * @name Deque
 * @package Prime\DataStructure
 * @since 30/10/2017
 * @author TomSailor
 * 
 * Um Deque (pronunciado "deck") é uma seqüência de valores em um buffer 
 * contíguo que cresce e diminui automaticamente. O nome é uma abreviatura 
 * comum de "fila de dupla extremidade".
 * Enquanto um Deque é muito semelhante a um vetor, ele oferece operações de 
 * tempo constante nas duas extremidades do buffer.
 * Ou seja:
 * shift, unshift, push e pop são todos O(1).
 */
class Deque implements \IteratorAggregate, \ArrayAccess, Sequence
{

    use CollectionTrait;
    use SequenceTrait;
}
