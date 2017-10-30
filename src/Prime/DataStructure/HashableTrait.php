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
 * @name HashableTrait
 * @package Prime\DataStructure
 * @since 30/10/2017
 * @author TomSailor
 */
trait HashableTrait
{

    /**
     * Determina se um objeto é igual à instância atual
     * @param object $obj O objeto para comparar com a instância atual, que é 
     * sempre uma instância da mesma classe.
     * @return bool TRUE se igual, FALSO caso contrário
     */
    public function equals(object $obj): bool
    {
        if ($obj instanceof HashableInterface) {
            $hash = $obj->hash();
        } else {
            $hash = spl_object_hash($obj);
        }

        if ($hash == $this->hash()) {
            return true;
        }
        return false;
    }

    /**
     * Esta função retorna um identificador único para o objeto. Este 
     * identificador por ser usado como uma chave hash para guardar objetos ou 
     * para identificar um objeto
     * @return string Uma string que é única para cada objeto e é sempre a mesma 
     * para o mesmo objeto.
     */
    public function hash(): string
    {
        return spl_object_hash($this);
    }

}
