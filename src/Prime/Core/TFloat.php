<?php

/*
 * Copyright (C) 2014 Marcus V Carpi
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Prime\Core;

use Prime\Core\TString;

/**
 * Descrição da Classe Float
 * @dateCreate 01/06/2014
 * @author Elton Luiz
 * @status Finalizada
 */
class TFloat extends TNumber {

    public function __construct($value = NULL) {
        if (!is_null($value)) {
            $this->setValue($value);
        }
    }

    /**
     * Define o valor do objeto TFloat
     * @param int|float|string $value
     */
    public function setValue($value) {
        if ($value instanceof TString) {
            $value = $value->getValue();
        }
        $this->data['value'] = (float)$value;
    }

    /**
     * Retorna o valor do objeto TFloat
     * @return float
     */
    public function getValue() {
        return $this->data['value'];
    }

    /**
     * Retorna um objeto String do parâmetro float passado
     * @param float $float
     * @return TString
     */
    public static function toString($float) {
        return new TString($float);
    }

    /**
     * Retorna um Objeto String desse objeto Float
     * @return TString
     */
    public function getString() {
        return new TString($this->getValue());
    }

    /**
     * Retorna uma instância de Float representa o valor float especificada.
     * @param float|TString $float
     * @return TFloat
     */
    public static function valueOf($float) {
        return new TFloat($float);
    }

    /**
     * Retorna um novo flutuador inicializada com o valor representado por o especificado
     *  String, como é realizada pelo método valueOf da classe Float.
     * @param \Prime\Core\TString $string
     * @return \Prime\core\TFloat
     */
    public static function parseFloat(TString $string) {
        return new TFloat($string->getValue());
    }

    /**
     * Retorna true se o número especificado é um Not-a-Number (NaN) valor, falso caso contrário.
     * @return boolean
     */
    public function isNaN() {
        if (is_nan($this->getValue())) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Verifica se o valor deste objeto Float é um infinito
     * @return boolean
     */
    public function isInfinite() {
        if (is_infinite($this->getValue())) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Compara os dois valores float especificada.
     * @param float $f1
     * @param float $f2
     * @return boolean
     */
    public function compare($f1, $f2) {
        $x = new TFloat($f1);
        $y = new TFloat($f2);
        if ($x->getValue() === $y->getValue()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Compara o valor passado com o valor float do objeto 
     * @param float $float
     * @return boolean
     */
    public function compareTo($float) {
        if (!$float instanceof TFloat) {
            $float = new TFloat($float);
        }
        if ($this->getValue() === $float->getValue()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
