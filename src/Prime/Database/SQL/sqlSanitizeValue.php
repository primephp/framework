<?php

/*
 * The MIT License
 *
 * Copyright 2017 wwwel.
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

namespace Prime\Database\SQL;

/**
 * @name sqlSanitizeValue
 * @package Prime\Database\SQL
 * @since29/10/2017
 * @author TomSailor
 */
trait sqlSanitizeValue {

    /**
     * 
     * Recebe um valor e faz as modificações necessárias
     * para ele ser interpretado pelo banco de dados
     * podendo ser um integer/string/boolean ou array.
     * @param $value = valor a ser transformado
     */
    private function sanitizeValue($value) {
        if (is_object($value)) {
            $value = $value->toString();
        }
        // caso seja um array
        if (is_array($value)) {
            // percorre os valores
            foreach ($value as $x) {
                // se for um inteiro
                if (is_integer($x)) {
                    $foo[] = $x;
                } else if (is_string($x)) {
                    // se for string, adiciona aspas
                    $foo[] = "'$x'";
                }
            }
            // converte o array em string separada por ","
            $result = '(' . implode(',', $foo) . ')';
        }
        // caso seja uma string
        else if (is_string($value)) {
            // adiciona aspas
            $result = "'$value'";
        }
        // caso seja valor nullo
        else if (is_null($value)) {
            // armazena NULL
            $result = 'NULL';
        }

        // caso seja booleano
        else if (is_bool($value)) {
            // armazena TRUE ou FALSE
            $result = $value ? 'TRUE' : 'FALSE';
        } else if ($value instanceof SqlSelect) {
            // caso seja uma instrução SQL SQLStatement
            $result = "(" . $value->getStatement() . ")";
        } else {
            // caso não se enquadre a nenhum padrão previamente estabelecido
            // retorna sem formatação
            $result = $value;
        }
        // retorna o valor
        return $result;
    }

}
