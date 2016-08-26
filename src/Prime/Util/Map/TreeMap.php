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
 * Descrição de TreeMap <br>
 *
 * Implementação de SortedMap que utiliza o algoritmo Red-Black para a ordenação
 * da árvore de elementos. Isto garante a ordenação ascendente da coleção, de 
 * acordo com a ordem natural dos elementos, definida pela implementação da 
 * interface Comparable ou Comparator. Use esta classe quando precisar de um 
 * conjunto (de elementos únicos) que deve estar sempre ordenado, mesmo sofrendo 
 * modificações. Análogo ao TreeSet, para casos onde a escrita é feita de uma 
 * só vez, antes da leitura dos elementos, talvez seja mais vantajoso fazer a 
 * ordenação em uma List, seguida de uma cópia para uma LinkedHashSet 
 * (dependendo do tamanho da coleção e do número de repetições de chaves).
 * @author 85101346
 * @name TreeMap
 * @package Prime\Util\Map
 * @createAt 24/08/2016
 */
class TreeMap implements \Prime\Util\Interfaces\ISortedMap {
    //put your code here
}
