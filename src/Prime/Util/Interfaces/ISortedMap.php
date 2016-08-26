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

namespace Prime\Util\Interfaces;

/**
 * Descrição de ISortedMap <br>
 * Interface que estende Map, adicionando a semântica de ordenação natural dos 
 * elementos, análogo à SortedSet. Também adiciona operações de partição da 
 * coleção, com os métodos headMap(k) - que retorna um SortedMap com os 
 * elementos de chaves anteriores a k -, subMap(k1,k2) - que retorna um 
 * SortedMap com os elementos de chaves compreendidas entre k1 e k2 - e 
 * tailMap(k) - que retorna um SortedMap com os elementos de chaves posteriores 
 * a k.
 * @author 85101346
 * @name ISortedMap
 * @package Prime\Util\Interfaces
 * @createAt 24/08/2016
 */
interface ISortedMap extends IMap {
    //put your code here
}
