<?php

namespace Prime\Util\Datetime;

use ArrayObject;
use Prime\Core\Object;
use UnexpectedValueException;

/*
 * Copyright (C) 2014 Elton Luiz This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Descrição de Datetime
 *
 * @package Prime\util\datetime
 * @author Elton Luiz
 *         @dateCreate 10/06/2014
 */
class Datetime extends Object {

    const SECONDS_PER_DAY = 86400;
    const FORMAT_ATOM = "Y-m-d\TH:i:sP";
    const FORMAT_COOKIE = "l, d-M-y H:i:s T";
    const FORMAT_ISO8601 = "Y-m-d\TH:i:sO";
    const FORMAT_RFC822 = "D, d M y H:i:s O";
    const FORMAT_RFC850 = "l, d-M-y H:i:s T";
    const FORMAT_RFC1036 = "D, d M y H:i:s O";
    const FORMAT_RFC1123 = "D, d M Y H:i:s O";
    const FORMAT_RFC2822 = "D, d M Y H:i:s O";
    const FORMAT_RFC3339 = "Y-m-d\TH:i:sP";
    const FORMAT_PTBR = "d/m/Y H:i:s";
    const FORMAT_AMERICAN = "Y-m-d H:i:s";
    const FORMAT_RSS = "D, d M Y H:i:s O";
    const FORMAT_W3C = "Y-m-d\TH:i:sP";

    /**
     *
     * @var ArrayObject
     */
    private $_date;

    /**
     * Instancia um objeto do tipo Datetime, podendo receber ou não uma string informando
     * a data e/ou datahora nos formatos americano ou brasileiro
     *
     * @param string $datetime        	
     */
    public function __construct($datetime = NULL) {
        $this->_date = new ArrayObject([]);
        if (!is_null($datetime)) {
            $this->setValue($datetime);
        }
    }

    /**
     * Verifica se a data é válida de acordo com o array de date_parse recebido como
     * parâmetro
     *
     * @param array $array        	
     * @return boolean
     */
    private function dateVerify(array $array) {
        if (checkdate($array ['month'], $array ['day'], $array ['year'])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Define o valor de Datetime, caso seja um valor inválido lança uma UnexpectedValueException
     *
     * @param string $value        	
     * @throws UnexpectedValueException
     */
    public function setValue($value) {
        $value = str_replace('/', '-', $value);
        $parse = date_parse($value);
        if ($this->dateVerify($parse)) {
            $get = getdate(strtotime($value));
            $this->_date = new ArrayObject(array_merge($parse, $get));
        } else {
            throw new UnexpectedValueException('Valor de data em ' . __CLASS__ . ' não é válido');
        }
    }

    /**
     * Retorna o timestamp relativo ao valor de datahora que o objeto foi configurado
     * retornando do contário NULLL se não há nenhuma datahora configurada
     *
     * @return int NULL
     */
    public function getTimestamp() {
        if ($this->_date->offsetExists(0)) {
            return $this->_date->offsetGet(0);
        } else {
            return NULL;
        }
    }

    /**
     * Retorna o mês, se Datetime recebeu um valor válido de datahora, do contrário retorna
     * <b>NULL</b>
     *
     * @return int NULL
     */
    public function getMonth() {
        if ($this->_date->offsetExists('mon')) {
            return $this->_date->offsetGet('mon');
        } else {
            return NULL;
        }
    }

    /**
     * Retorna o ano, se Datetime recebeu um valor válido de datahora, do contrário retorna
     * <b>NULL</b>
     *
     * @return int NULL
     */
    public function getYear() {
        if ($this->_date->offsetExists('year')) {
            return $this->_date->offsetGet('year');
        } else {
            return NULL;
        }
    }

    /**
     * Retorna o dia do mês, se Datetime recebeu um valor válido de datahora, do contrário retorna
     * <b>NULL</b>
     *
     * @return int NULL
     */
    public function getDay() {
        if ($this->_date->offsetExists('day')) {
            return $this->_date->offsetGet('day');
        } else {
            return NULL;
        }
    }

    /**
     * Retorna as horas, se Datetime recebeu um valor válido de datahora, do contrário retorna
     * <b>NULL</b>
     *
     * @return int NULL
     */
    public function getHour() {
        if ($this->_date->offsetExists('hour')) {
            return $this->_date->offsetGet('hour');
        } else {
            return NULL;
        }
    }

    /**
     * Retorna os minutos, se Datetime recebeu um valor válido de datahora, do contrário retorna
     * <b>NULL</b>
     *
     * @return int NULL
     */
    public function getMinute() {
        if ($this->_date->offsetExists('minute')) {
            return $this->_date->offsetGet('minute');
        } else {
            return NULL;
        }
    }

    /**
     * Retorna os segundos, se Datetime recebeu um valor válido de datahora, do contrário retorna
     * <b>NULL</b>
     *
     * @return int NULL
     */
    public function getSecond() {
        if ($this->_date->offsetExists('second')) {
            return $this->_date->offsetGet('second');
        } else {
            return NULL;
        }
    }

    /**
     * Retorna o conteúdo de Datetime no formato passado como parâmetro, caso não tenha sido passado
     * nenhum parâmetro, retorna NULL
     *
     * @param string $format
     *        	O formato que deverá ser retornada a datahora
     * @return string NULL a string representando a datahora do objeto, ou NULL caso não
     *         se tenha sido configurado a datahora
     */
    public function get($format = Datetime::FORMAT_AMERICAN) {
        if (!is_null($this->getTimestamp())) {
            return date($format, $this->getTimestamp());
        } else {
            return NULL;
            $this->__destruct();
        }
    }

    /**
     * Verifica se a data de Datetime é uma data válida
     *
     * @return boolean Retorna TRUE caso a data seja uma data válida e FALSE caso seja uma data inválida
     */
    public function isValid() {
        return $this->dateVerify(checkdate($this->getMonth(), $this->getDay(), $this->getYear()));
    }

    /**
     * Retorna o conteúdo do objeto no formato "Y-m-d H:i:s"
     *
     * @see Object::toString()
     */
    public function toString() {
        return $this->get();
    }

}
