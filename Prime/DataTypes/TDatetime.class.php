<?php

namespace Prime\DataTypes;

use Prime\Filters\Sanitize,
    Prime\DataTypes\Interfaces\IType;

/**
 * Descrição da Classe TDatetime
 * @name DateType
 * @package Prime\DataTypes
 * @version 1.0
 * @author tom
 * @since 22/10/2011
 * @access public
 */
class TDatetime implements IType {

    const SECONDS_PER_DAY = 86400;

    /**
     * Lista os nomes dos dias da semana
     * @var array 
     */
    protected $days = array("Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado");

    /**
     * Lista os nomes dos meses do ano
     * @var array 
     */
    protected $months = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

    /**
     * Total de dias de cada mês do ano
     * @var type 
     */
    protected $totalDays = array(0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    protected $locale = array("en_US", "pt_BR");
    private $year;
    private $month;
    private $date;
    private $startTimeStamp;
    private $iso;
    private $inputDate;

    /**
     * Deve se ter atenção às alterações no construtor 
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
        //echo $fullDate;
        $this->inputDate = (!is_null($fullDate)) ? $fullDate : date("Y-m-d H:i:s");
        $this->iso = $iso;
        $this->startTimeStamp = getdate(strtotime($this->inputDate));
    }

    /**
     * Retorna o valor no formato
     * Y-m-d H:i:s
     * @return date Y-m-d H:i:s 
     */
    public function getValue() {
        return $this->format('Y-m-d H:i:s');
    }

    /**
     * @return void
     * Reconfigura o estado de date;
     * @param string $fullDate
     */
    public function changeDate($fullDate = null, $iso = false) {
        $fullDate = str_replace('/', '-', $fullDate);
        //echo $fullDate;
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
        if (isset($this->startTimeStamp[0])) {
            return date($format, $this->startTimeStamp[0]);
        } else {
            return date($format);
        }
    }

    /**
     * Retorna da Data no formato 
     * brasileiro dd/mm/YYYY
     * @return string
     */
    public function getDatePTBR() {
        return $this->format('d/m/Y');
    }

    /**
     * Retorna da Data/Hora no formato
     * brasileiro
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
     * Retorna  os segundos passados desde 1 janeiro de 1970 00:00:00
     * também conhecida com era Unix, até o instante da instanciação
     * de Date
     * @return integer
     */
    public function getTime() {
        return $this->startTimeStamp[0];
    }

    /**
     * Retorna o dia do mes no formato legivel.
     * @return integer
     */
    public function getDate() {
        return $this->format('d');
    }

    /**
     * Retorna a representação numerica do mes no formato legivel.
     * um intervalo de 1 a 12, deve-se ficar atento, já que com
     * uso de array o primeiro mes começa em 1(um) e não 0 (zero)
     * @return integer
     */
    public function getMonth() {
        return $this->startTimeStamp['mon'];
    }

    /**
     * Retorna a representacão gráfica do mes por extenso
     * se o parâmetro opcional no construtor for true o valor
     * retornado é em inglês
     * @return string
     */
    public function getMonthName() {
        if ($this->iso == true) {
            return $this->startTimeStamp['month'];
        }
        return $this->months[(int) $this->getMonth()];
    }

    /**
     * Retorna a representação gráfica do mes por extenso
     * se o parâmetro opcional no construtor for true o valor
     * retornado é em inglês
     * @return string
     */
    public function getMonthShort() {
        if ($this->iso == true) {
            return substr($this->startTimeStamp['month'], 0, 3);
        }
        return substr($this->months[(int) $this->getMonth()], 0, 3);
    }

    /**
     * @return string
     * Retorna o nome do dia da semana  na sua representação
     * alfabética, por extenso
     *
     */
    public function getDayOfWeek() {
        if ($this->iso == true) {
            return $this->startTimeStamp['weekday'];
        }
        return $this->days[$this->startTimeStamp['wday']];
    }

    /**
     * Retorna o dia do mês no formato numérido
     * @return int 
     */
    public function getDay() {
        return $this->startTimeStamp['mday'];
    }

    public function getDayName() {
        $names = array(
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
            31 => 'trinta e um',
        );

        return $names[$this->startTimeStamp['mday']];
    }

    /**
     * @return string
     * Retorna o nome do dia da semana em abreviado, na sua representação
     * alfabética
     *
     */
    public function getShortDayOfWeek() {
        if ($this->iso == true) {
            return substr($this->startTimeStamp['weekday'], 0, 3);
        }
        return substr($this->days[$this->startTimeStamp['wday']], 0, 3);
    }

    /**
     * Retorna a representação numérica do dia da semana.
     * um intervalo de 0 a 6, 0 representado o primeiro
     * dia da semana com domingo e 6  sábado;
     * @return integer
     */
    public function getNumericalDayOfWeek() {
        return $this->startTimeStamp['wday'];
    }

    /**
     * Retorna o valor do ano do instante atual.
     * @return integer
     */
    public function getYear() {
        return $this->startTimeStamp['year'];
    }

    /**
     * Retorna o valor da hora do instante atual.
     * @return integer
     */
    public function getHours() {
        return $this->startTimeStamp['hours'];
    }

    /**
     * Retorna o valor da hora do instante atual.
     * @return integer
     */
    public function getHoursString() {
        return $this->format('H:i:s');
    }

    /**
     * Retorna os minutos do instante atual.
     * @return integer
     */
    public function getMinutes() {
        return $this->startTimeStamp['minutes'];
    }

    /**
     * Retorna os segundos do instante atual.
     * @return integer
     */
    public function getSeconds() {
        return $this->startTimeStamp['seconds'];
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
     * O numero de segundos desde o momento em que o objeto
     * foi criado acrescido dos segundos passados como parametros;
     * @param string $seconds
     * @return integer
     */
    public function quantityOfMiliseconds(Date $date) {
        $seconds = $this->startTimeStamp[0] - $date->getTime();
        $seconds = ($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return $seconds * 1000;
    }

    /**
     * Retorna a quantidade de segundos desde
     * o momento da instanciação do objeto Date mais o valor passado
     * @return string
     * @param string $seconds
     */
    public function quantityOfSeconds(Date $date) {
        $seconds = $this->startTimeStamp[0] - $date->getTime();
        //  $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return $seconds;
    }

    /**
     * A quantidade de minutos calculada entre a data passada e a atual;
     * @return integer
     */
    public function quantityOfMinutes(Date $date) {
        $seconds = $this->startTimeStamp[0] - $date->getTime();
        // $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return ($seconds / 60);
    }

    /**
     * @return integer
     */
    public function quantityOfHours(Date $date) {
        $seconds = $this->startTimeStamp[0] - $date->getTime();
        // $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return ($seconds / 3600);
    }

    /**
     * @return integer
     */
    public function quantityOfDays(Date $date) {
        $seconds = $this->startTimeStamp[0] - $date->getTime();

        // $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return ($seconds / 3600 / 24);
    }

    /**
     * @return integer
     */
    public function quantityOfWeeks(Date $date) {
        $seconds = $this->startTimeStamp[0] - $date->getTime();
        //  $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return ($seconds / 3600 / (7 * 24));
    }

    /**
     * A quantidade de meses entre a data passada e a data atual;
     * @return interger
     */
    public function quantityOfMonths(Date $date) {
        $seconds = $this->startTimeStamp[0] - $date->getTime();
        //  $seconds =($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        return ($seconds / 3600 / (24 * 30));
    }

    /**
     * FIXME: estou desconsiderando ainda o bisexto
     * @return integer
     */
    public function quantityOfYears(TDatetime $date = NULL) {
        if (is_null($date)) {
            $date = new TDatetime();
        }
        $seconds = $this->startTimeStamp[0] - $date->getTimeStamp();
        $seconds = ($seconds < 0 ) ? (-1 * $seconds) : $seconds;
        // verifica se é ano bisexto, modifica o vetor $totalDays
        $year = (date("L", mktime(0, 0, 0, $this->month, 1, $this->year))) ? 366 : 365;

        return ($seconds / 3600 / (24 * $year));
    }

    public function getTimeRegister() {
        return date("YmdHis");
    }

    /**
     * Uma representação do data-hora em que o metodo foi chamado,
     * seguindo o padrão pt_BR. Ou seja, timestamp atual
     * @return string
     */
    public function getTimeStamp() {
        return strtotime(date("d-m-Y H:i:s"));
    }

    /**
     * converts SQL datetime format to UNIX time stamp or format by Date() if the second parameter is specified
     * 
     * @static     
     * @param string $datetime DATE, TIME or DATETIME format
     * @param string $format directly format the time using Date() function
     * @return mixed integer (timestamp) if $format is empty, otherwise formated string
     */
    static function Time2Stamp($datetime, $format = '') {
        switch (strlen($datetime)) {
            // DATETIME
            case 19:
                $year = IntVal(SubStr($datetime, 0, 4));
                $month = IntVal(SubStr($datetime, 5, 2));
                $day = IntVal(SubStr($datetime, 8, 2));
                $hour = IntVal(SubStr($datetime, 11, 2));
                $minute = IntVal(SubStr($datetime, 14, 2));
                $second = IntVal(SubStr($datetime, 17, 2));

                if ($year == 0) {
                    $stamp = 0;
                } else {
                    $stamp = MkTime($hour, $minute, $second, $month, $day, $year);
                }

                if ($stamp == -1) {
                    return false;
                }

                break;

            // DATE
            case 10:

                $year = IntVal(SubStr($datetime, 0, 4));
                $month = IntVal(SubStr($datetime, 5, 2));
                $day = IntVal(SubStr($datetime, 8, 2));

                $stamp = MkTime(0, 0, 0, $month, $day, $year);
                if ($stamp == -1) {
                    return false;
                }

                break;

            // TIME
            case 8:

                $hour = IntVal(SubStr($datetime, 0, 2));
                $minute = IntVal(SubStr($datetime, 3, 2));
                $second = IntVal(SubStr($datetime, 6, 2));

                $stamp = MkTime($hour, $minute, $second, 1, 1, 1970);
                if ($stamp == -1) {
                    return false;
                }

                break;

            default:
                return false;
        }

        if ($format == '') {
            return $stamp;
        } else {
            return Date($format, $stamp);
        }
    }

    /**
     * converts UNIX time stamp to SQL-DATETIME
     * 
     * @static     
     * @param integer $stamp unix timestamp
     * @return string DATETIME
     */
    static function Stamp2DATETIME($stamp) {
        return Date('Y-m-d H:i:s', $stamp);
    }

    /**
     * converts UNIX time stamp to SQL-DATE
     * 
     * @static     
     * @param integer $stamp unix timestamp
     * @return string DATE
     */
    static function Stamp2DATE($stamp) {
        return Date('Y-m-d', $stamp);
    }

    /**
     * converts UNIX time stamp to SQL-TIME
     * 
     * @static
     * @param integer $stamp unix timestamp
     * @return string TIME
     */
    static function Stamp2TIME($stamp) {
        return Date('H:i:s', $stamp);
    }

    /**
     * Computes difference in days
     * 
     * @static     
     * @param integer $day1 unix timestamp
     * @param integer $day2 unix timestamp
     * @return float number of days
     */
    static function DiffDays($day1, $day2) {
        return IntVal(abs($day2 - $day1) / self::SECONDS_PER_DAY);
    }

    public function getTimeElapsed() {
        $timeNow = time();
        $timeRes = $timeNow - $this->startTimeStamp[0];
        $nar = 0;

        // variável de retorno
        $r = "";

        // Agora
        if ($timeRes == 0) {
            $r = "agora";
        } else
        // Segundos
        if ($timeRes > 0 and $timeRes < 60) {
            $r = $timeRes . " segundos atr&aacute;s";
        } else
        // Minutos
        if (($timeRes > 59) and ($timeRes < 3599)) {
            $timeRes = $timeRes / 60;
            if (round($timeRes, $nar) >= 1 and round($timeRes, $nar) < 2) {
                $r = round($timeRes, $nar) . " minuto atr&aacute;s";
            } else {
                $r = round($timeRes, $nar) . " minutos atr&aacute;s";
            }
        } else
        // Horas
        // Usar expressao regular para fazer hora e MEIA
        if ($timeRes > 3559 and $timeRes < 86400) {
            $timeRes = $timeRes / 3600;

            if (round($timeRes, $nar) >= 1 and round($timeRes, $nar) < 2) {
                $r = round($timeRes, $nar) . " hora atr&aacute;s";
            } else {
                $r = round($timeRes, $nar) . " horas atr&aacute;s";
            }
        } else
        // Dias
        // Usar expressao regular para fazer dia e MEIO
        if ($timeRes > 86400 and $timeRes < 2591999) {

            $timeRes = $timeRes / 86400;
            if (round($timeRes, $nar) >= 1 and round($timeRes, $nar) < 2) {
                $r = round($timeRes, $nar) . " dia atr&aacute;s";
            } else {

                preg_match('/(\d*)\.(\d)/', $timeRes, $matches);

                if ($matches[2] >= 5) {
                    $ext = round($timeRes, $nar) - 1;

                    // Imprime o dia
                    $r = $ext;

                    // Formata o dia, singular ou plural
                    if ($ext >= 1 and $ext < 2) {
                        $r.= " dia ";
                    } else {
                        $r.= " dias ";
                    }

                    // Imprime o final da data
                    $r.= "&frac12; atr&aacute;s";
                } else {
                    $r = round($timeRes, 0) . " dias atr&aacute;s";
                }
            }
        } else
        // Meses
        if ($timeRes > 2592000 and $timeRes < 31103999) {

            $timeRes = $timeRes / 2592000;
            if (round($timeRes, $nar) >= 1 and round($timeRes, $nar) < 2) {
                $r = round($timeRes, $nar) . " mês atr&aacute;s";
            } else {

                preg_match('/(\d*)\.(\d)/', $timeRes, $matches);

                if ($matches[2] >= 5) {
                    $ext = round($timeRes, $nar) - 1;

                    // Imprime o mes
                    $r.= $ext;

                    // Formata o mes, singular ou plural
                    if ($ext >= 1 and $ext < 2) {
                        $r.= " mês ";
                    } else {
                        $r.= " meses ";
                    }

                    // Imprime o final da data
                    $r.= "&frac12; atr&aacute;s";
                } else {
                    $r = round($timeRes, 0) . " meses atr&aacute;s";
                }
            }
        } else
        // Anos
        if ($timeRes > 31104000) {
            $r = $this->getDatePTBR();
        }
        return $r;
    }

    /**
     * Retorna a data por Extenso no padrão brasileiro
     * @return string 
     */
    public function getLongPtBr() {
        return $this->getDay() . ' de ' . $this->getMonthName() . ' de ' . $this->getYear();
    }

    /**
     * Retorna a data de Nascimento de acordo com o parâmetro passado baseado
     * na data atual
     * @param type $dataNascimento 
     * @return int $ano
     */
    public static function getAge($dataNascimento) {
        $date = new TDatetime($dataNascimento);
        $nascimento = $date->getDateUS();
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

        return (int) $ano;
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
            case 'y':
                $year -= $value;
                break;
            case 'm':
                $month -= $value;
                break;
            case 'd':
                $day -= $value;
                break;
            case 'h':
                $hour -= $value;
                break;
            case 'i':
                $minute -= $value;
                break;
            case 's':
                $second -= $value;
                break;

            default:
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
            case 'y':
                $year += $value;
                break;
            case 'm':
                $month += $value;
                break;
            case 'd':
                $day += $value;
                break;
            case 'h':
                $hour += $value;
                break;
            case 'i':
                $minute += $value;
                break;
            case 's':
                $second += $value;
                break;
            default:
                break;
        }
        $this->changeDate(date('Y-m-d H:i:s', mktime($hour, $minute, $second, $month, $day, $year)));
    }

    public function getClone(){
        return clone $this;
    }
}


