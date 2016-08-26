<?php

/*
 * Copyright (C) 2014 comforsup-0213 This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details. You should have received a copy of the GNU General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Prime\Util\Datetime;

/**
 * Descrição de DatetimeString
 *
 * @package Prime\util\datetime
 * @author Elton Luiz
 *         @dateCreate 10/06/2014
 */
class DatetimeString {

    const SECONDS_PER_DAY = 86400;

    /**
     * Lista os nomes dos dias da semana
     * 
     * @var array
     */
    protected $days = [
        "Domingo",
        "Segunda",
        "Terça",
        "Quarta",
        "Quinta",
        "Sexta",
        "Sábado"
    ];

    /**
     * Lista os nomes dos meses do ano
     * 
     * @var array
     */
    protected $months = [
        "",
        "Janeiro",
        "Fevereiro",
        "Março",
        "Abril",
        "Maio",
        "Junho",
        "Julho",
        "Agosto",
        "Setembro",
        "Outubro",
        "Novembro",
        "Dezembro"
    ];

    /**
     * Total de dias de cada mês do ano
     * 
     * @var type
     */
    protected $totalDays = [
        0,
        31,
        28,
        31,
        30,
        31,
        30,
        31,
        31,
        30,
        31,
        30,
        31
    ];
    protected $locale = [
        "en_US",
        "pt_BR"
    ];
    private $year;
    private $month;
    private $date;
    private $startTimeStamp;
    private $iso;
    private $inputDate;

    /**
     * Deve se ter atenção às alterações no construtor
     * 
     * @param string $date        	
     * @param boolean $iso        	
     */
    public function __construct($fullDate = null, $iso = false) {
        $this->setValue($fullDate, $iso);
    }

    public function setValue($fullDate, $iso = FALSE) {
        date_default_timezone_set("Brazil/East");
        if (!is_null($fullDate)) {
            $fullDate = str_replace('/', '-', $fullDate);
        }
        // echo $fullDate;
        $this->inputDate = (!is_null($fullDate)) ? $fullDate : date("Y-m-d H:i:s");
        $this->iso = $iso;
        $this->startTimeStamp = getdate(strtotime($this->inputDate));
    }

    /**
     * Retorna o valor no formato
     * Y-m-d H:i:s
     * 
     * @return date Y-m-d H:i:s
     */
    public function getValue() {
        return $this->format('Y-m-d H:i:s');
    }

    /**
     *
     * @return void Reconfigura o estado de date;
     * @param string $fullDate        	
     */
    public function changeDate($fullDate = null, $iso = false) {
        $fullDate = str_replace('/', '-', $fullDate);
        // echo $fullDate;
        $this->inputDate = $fullDate;
        $aDate = null;
        $this->iso = $iso;
        $this->startTimeStamp = getdate(strtotime($this->inputDate));
    }

    /**
     *
     * @param type $format        	
     * @return type
     */
    public function format($format) {
        if (isset($this->startTimeStamp [0])) {
            return date($format, $this->startTimeStamp [0]);
        } else {
            return date($format);
        }
    }

    /**
     * Retorna da Data no formato
     * brasileiro dd/mm/YYYY
     * 
     * @return string
     */
    public function getDatePTBR() {
        return $this->format('d/m/Y');
    }

    /**
     * Retorna da Data/Hora no formato
     * brasileiro
     * 
     * @return type
     */
    public function getDateTimeBR() {
        return $this->format('d/m/Y H:i:s');
    }

    /**
     * Formata a data no padrão americano, que é como está nas base de dados
     *
     * @return string
     */
    public function getDateUS() {
        return $this->format('Y-m-d');
    }

    public function getDateTimeUSA() {
        return $this->format('Y-m-d H:i:s');
    }

    /**
     * Retorna os segundos passados desde 1 janeiro de 1970 00:00:00
     * também conhecida com era Unix, até o instante da instanciação
     * de Date
     * 
     * @return integer
     */
    public function getTime() {
        return $this->startTimeStamp [0];
    }

    /**
     * Retorna o dia do mes no formato legivel.
     * 
     * @return integer
     */
    public function getDate() {
        return $this->format('d');
    }

    /**
     * Retorna a representação numerica do mes no formato legivel.
     * um intervalo de 1 a 12, deve-se ficar atento, já que com
     * uso de array o primeiro mes começa em 1(um) e não 0 (zero)
     * 
     * @return integer
     */
    public function getMonth() {
        return $this->startTimeStamp ['mon'];
    }

    /**
     * Retorna a representacão gráfica do mes por extenso
     * se o parâmetro opcional no construtor for true o valor
     * retornado é em inglês
     * 
     * @return string
     */
    public function getMonthName() {
        if ($this->iso == true) {
            return $this->startTimeStamp ['month'];
        }
        return $this->months [(int)$this->getMonth()];
    }

    /**
     * Retorna a representação gráfica do mes por extenso
     * se o parâmetro opcional no construtor for true o valor
     * retornado é em inglês
     * 
     * @return string
     */
    public function getMonthShort() {
        if ($this->iso == true) {
            return substr($this->startTimeStamp ['month'], 0, 3);
        }
        return substr($this->months [(int)$this->getMonth()], 0, 3);
    }

    /**
     *
     * @return string Retorna o nome do dia da semana na sua representação
     *         alfabética, por extenso
     *        
     */
    public function getDayOfWeek() {
        if ($this->iso == true) {
            return $this->startTimeStamp ['weekday'];
        }
        return $this->days [$this->startTimeStamp ['wday']];
    }

    /**
     * Retorna o dia do mês no formato numérido
     * 
     * @return int
     */
    public function getDay() {
        return $this->startTimeStamp ['mday'];
    }

    public function getDayName() {
        $names = [
            1 => 'primeiro',
            2 => 'dois',
            3 => 'três',
            4 => 'quatro',
            5 => 'cinco',
            6 => 'seis',
            7 => 'sete',
            8 => 'oito',
            9 => 'nove',
            10 => 'dez',
            11 => 'onze',
            12 => 'doze',
            13 => 'treze',
            14 => 'quatorze',
            15 => 'quinze',
            16 => 'dezesseis',
            17 => 'dezessete',
            18 => 'dezoito',
            19 => 'dezenove',
            20 => 'vinte',
            21 => 'vinte e um',
            22 => 'vinte e dois',
            23 => 'vinte e três',
            24 => 'vinte e quatro',
            25 => 'vinte e cinco',
            26 => 'viinte e seis',
            27 => 'vinte e sete',
            28 => 'vinte e oito',
            29 => 'vinte e nove',
            30 => 'trinta',
            31 => 'trinta e um'
        ];

        return $names [$this->startTimeStamp ['mday']];
    }

    /**
     *
     * @return string Retorna o nome do dia da semana em abreviado, na sua representação
     *         alfabética
     *        
     */
    public function getShortDayOfWeek() {
        if ($this->iso == true) {
            return substr($this->startTimeStamp ['weekday'], 0, 3);
        }
        return substr($this->days [$this->startTimeStamp ['wday']], 0, 3);
    }

    /**
     * Retorna a representação numérica do dia da semana.
     * um intervalo de 0 a 6, 0 representado o primeiro
     * dia da semana com domingo e 6 sábado;
     * 
     * @return integer
     */
    public function getNumericalDayOfWeek() {
        return $this->startTimeStamp ['wday'];
    }

    /**
     * Retorna o valor do ano do instante atual.
     * 
     * @return integer
     */
    public function getYear() {
        return $this->startTimeStamp ['year'];
    }

    /**
     * Retorna o valor da hora do instante atual.
     * 
     * @return integer
     */
    public function getHours() {
        return $this->startTimeStamp ['hours'];
    }

    /**
     * Retorna o valor da hora do instante atual.
     * 
     * @return integer
     */
    public function getHoursString() {
        return $this->format('H:i:s');
    }

    /**
     * Retorna os minutos do instante atual.
     * 
     * @return integer
     */
    public function getMinutes() {
        return $this->startTimeStamp ['minutes'];
    }

    /**
     * Retorna os segundos do instante atual.
     * 
     * @return integer
     */
    public function getSeconds() {
        return $this->startTimeStamp ['seconds'];
    }

    public function getNow() {
        return strtotime("now");
    }

    public function teste() {
        echo "<pre>";
        var_dump($this->startTimeStamp);
        echo "</pre>";
    }

    /**
     *
     *
     * O numero de segundos desde o momento em que o objeto
     * foi criado acrescido dos segundos passados como parametros;
     * 
     * @param string $seconds        	
     * @return integer
     */
    public function quantityOfMiliseconds(Date $date) {
        $seconds = $this->startTimeStamp [0] - $date->getTime();
        $seconds = ($seconds < 0) ? (- 1 * $seconds) : $seconds;
        return $seconds * 1000;
    }

    /**
     * Retorna a quantidade de segundos desde
     * o momento da instanciação do objeto Date mais o valor passado
     * 
     * @return string
     * @param string $seconds        	
     */
    public function quantityOfSeconds(Date $date) {
        $seconds = $this->startTimeStamp [0] - $date->getTime();
        // $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return $seconds;
    }

    /**
     * A quantidade de minutos calculada entre a data passada e a atual;
     * 
     * @return integer
     */
    public function quantityOfMinutes(Date $date) {
        $seconds = $this->startTimeStamp [0] - $date->getTime();
        // $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return ($seconds / 60);
    }

    /**
     *
     * @return integer
     */
    public function quantityOfHours(Date $date) {
        $seconds = $this->startTimeStamp [0] - $date->getTime();
        // $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return ($seconds / 3600);
    }

    /**
     *
     * @return integer
     */
    public function quantityOfDays(Date $date) {
        $seconds = $this->startTimeStamp [0] - $date->getTime();

        // $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return ($seconds / 3600 / 24);
    }

    /**
     *
     * @return integer
     */
    public function quantityOfWeeks(Date $date) {
        $seconds = $this->startTimeStamp [0] - $date->getTime();
        // $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return ($seconds / 3600 / (7 * 24));
    }

    /**
     * A quantidade de meses entre a data passada e a data atual;
     * 
     * @return interger
     */
    public function quantityOfMonths(Date $date) {
        $seconds = $this->startTimeStamp [0] - $date->getTime();
        // $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return ($seconds / 3600 / (24 * 30));
    }

    /**
     * FIXME: estou desconsiderando ainda o bisexto
     * 
     * @return integer
     */
    public function quantityOfYears(Datetime $date = NULL) {
        if (is_null($date)) {
            $date = new TDatetime ();
        }
        $seconds = $this->startTimeStamp [0] - $date->getTimeStamp();
        $seconds = ($seconds < 0) ? (- 1 * $seconds) : $seconds;
        // verifica se é ano bisexto, modifica o vetor $totalDays
        $year = (date("L", mktime(0, 0, 0, $this->month, 1, $this->year))) ? 366 : 365;

        return ($seconds / 3600 / (24 * $year));
    }

    /**
     * Computes difference in days
     *
     * @static
     *
     * @param integer $day1
     *        	unix timestamp
     * @param integer $day2
     *        	unix timestamp
     * @return float number of days
     */
    static function DiffDays($day1, $day2) {
        return IntVal(abs($day2 - $day1) / self::SECONDS_PER_DAY);
    }

    public function getDateTimeIso() {
        $date = new DateTime($this->getDateTimeUSA());
        return $date->format(DateTime::ISO8601);
    }

    public function getTimeElapsed() {
        $timeNow = time();
        $timeRes = $timeNow - $this->startTimeStamp [0];
        $nar = 0;

        // variável de retorno
        $r = "";

        // Agora
        if ($timeRes == 0) {
            $r = "agora";
        } else
        // Segundos
        if
        ($timeRes > 0 and $timeRes < 60) {
            $r = $timeRes . " segundos atrás";
        } else
        // Minutos
        if
        (($timeRes > 59) and ( $timeRes < 3599)) {
            $timeRes = $timeRes / 60;
            if (round($timeRes, $nar) >= 1 and round($timeRes, $nar) < 2) {
                $r = round($timeRes, $nar) . " minuto atrás";
            } else {
                $r = round($timeRes, $nar) . " minutos atrás";
            }
        } else
        // Horas
        // Usar expressao regular para fazer hora e MEIA
        if
        ($timeRes > 3559 and $timeRes < 86400) {
            $timeRes = $timeRes / 3600;

            if (round($timeRes, $nar) >= 1 and round($timeRes, $nar) < 2) {
                $r = round($timeRes, $nar) . " hora atrás";
            } else {
                $r = round($timeRes, $nar) . " horas atrás";
            }
        } else
        // Dias
        // Usar expressao regular para fazer dia e MEIO
        if
        ($timeRes > 86400 and $timeRes < 2591999) {

            $timeRes = $timeRes / 86400;
            if (round($timeRes, $nar) >= 1 and round($timeRes, $nar) < 2) {
                $r = round($timeRes, $nar) . " dia atrás";
            } else {

                preg_match('/(\d*)\.(\d)/', $timeRes, $matches);

                if ($matches [2] >= 5) {
                    $ext = round($timeRes, $nar) - 1;

                    // Imprime o dia
                    $r = $ext;

                    // Formata o dia, singular ou plural
                    if ($ext >= 1 and $ext < 2) {
                        $r .= " dia ";
                    } else {
                        $r .= " dias ";
                    }

                    // Imprime o final da data
                    $r .= "1/2 atrás";
                } else {
                    $r = round($timeRes, 0) . " dias atrás";
                }
            }
        } else
        // Meses
        if
        ($timeRes > 2592000 and $timeRes < 31103999) {

            $timeRes = $timeRes / 2592000;
            if (round($timeRes, $nar) >= 1 and round($timeRes, $nar) < 2) {
                $r = round($timeRes, $nar) . " mês atrás";
            } else {

                preg_match('/(\d*)\.(\d)/', $timeRes, $matches);

                if ($matches [2] >= 5) {
                    $ext = round($timeRes, $nar) - 1;

                    // Imprime o mes
                    $r .= $ext;

                    // Formata o mes, singular ou plural
                    if ($ext >= 1 and $ext < 2) {
                        $r .= " mês ";
                    } else {
                        $r .= " meses ";
                    }

                    // Imprime o final da data
                    $r .= "1/2 atrás";
                } else {
                    $r = round($timeRes, 0) . " meses atrás";
                }
            }
        } else
        // Anos
        if
        ($timeRes > 31104000) {
            $r = $this->getDatePTBR();
        }
        return $r;
    }

    /**
     * Retorna a data por Extenso no padrão brasileiro
     * 
     * @return string
     */
    public function getLongPtBr() {
        return $this->getDay() . ' de ' . $this->getMonthName() . ' de ' . $this->getYear();
    }

    /**
     * Retorna a data de Nascimento de acordo com o parâmetro passado baseado
     * na data atual
     * 
     * @param type $dataNascimento        	
     * @return int $ano
     */
    public static function getAge($dataNascimento) {
        if ($dataNascimento instanceof Datetime) {
            $date = $dataNascimento;
        } else {
            $date = new Datetime($dataNascimento);
        }
        $nascimento = $date->get('Y-m-d');
        $hoje = date('Y-m-d');

        $ano = $hoje - $nascimento;

        $mesAtual = date('m');
        $mesNascimento = $date->getMonth();

        $diaAtual = date('d');
        $diaNascimento = $date->getDay();

        if ($mesAtual < $mesNascimento) {
            $ano -= 1;
        } else if ($mesAtual == $mesNascimento) {
            if ($diaAtual < $diaNascimento) {
                $ano -= 1;
            }
        }

        return (int)$ano;
    }

    public function decrease($param) {
        $value = Sanitize::integer($param);
        $param = Sanitize::letters($param);

        $hour = $this->getHours();
        $minute = $this->getMinutes();
        $second = $this->getSeconds();
        $month = $this->getMonth();
        $day = $this->getDay();
        $year = $this->getYear();

        switch ($param) {
            case 'y' :
                $year -= $value;
                break;
            case 'm' :
                $month -= $value;
                break;
            case 'd' :
                $day -= $value;
                break;
            case 'h' :
                $hour -= $value;
                break;
            case 'i' :
                $minute -= $value;
                break;
            case 's' :
                $second -= $value;
                break;

            default :
                break;
        }
        $this->changeDate(date('Y-m-d H:m:s', mktime($hour, $minute, $second, $month, $day, $year)));
    }

    public function add($param) {
        $value = Sanitize::integer($param);
        $param = Sanitize::letters($param);

        $hour = $this->getHours();
        $minute = $this->getMinutes();
        $second = $this->getSeconds();
        $month = $this->getMonth();
        $day = $this->getDay();
        $year = $this->getYear();

        switch ($param) {
            case 'y' :
                $year += $value;
                break;
            case 'm' :
                $month += $value;
                break;
            case 'd' :
                $day += $value;
                break;
            case 'h' :
                $hour += $value;
                break;
            case 'i' :
                $minute += $value;
                break;
            case 's' :
                $second += $value;
                break;
            default :
                break;
        }
        $this->changeDate(date('Y-m-d H:i:s', mktime($hour, $minute, $second, $month, $day, $year)));
    }

    public function getClone() {
        return clone $this;
    }

}
