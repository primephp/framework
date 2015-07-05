<?php

namespace Prime\DataTypes;

use DateTime as PHPDateTime;
use Prime\Filters\Sanitize;

/**
 * Descrição da Classe TDatetime
 * @name DateType
 * @package Prime\DataTypes
 * @version 1.0
 * @author tom
 * @since 22/10/2011
 * @access public
 * @deprecated since version 2.0
 */
class Datetime {

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

    /**
     * Uma representação do data-hora em que o metodo foi chamado,
     * seguindo o padrão pt_BR. Ou seja, timestamp atual
     * @return string
     */
    public function getTimeStamp() {
        return strtotime(date("d-m-Y H:i:s"));
    }

    public function getDateTimeIso() {
        $date = new PHPDateTime($this->getDateTimeUSA());
        return $date->format(PHPDateTime::ISO8601);
    }

    public function getTimeElapsed() {
        $data_atual = time(); // data atual em segundos
// a data vem do banco de dados então ela está no formato americano.
// se sua data está no formato dd/mm/aaaa hh:mm:ss basta descomentar (tirar as duas barras //) a linha de baixo
//date("Y-m-d H:i:s",$data);
// separamos as partes da data
        list($ano, $mes, $dia) = explode("-", $this->getDateTimeUSA());
        list($dia, $hora) = explode(" ", $dia);
        list($hora, $min, $seg) = explode(":", $hora);
// transformamos a data do banco em segundos usando a função mktime()
        $data_banco = mktime($hora, $min, $seg, $mes, $dia, $ano);

        $diferenca = $data_atual - $data_banco; // subtraímos a data atual menos a data do banco em segundos
        $minutos = $diferenca / 60; // dividimos os segundos por 60 para transformá-los em minutos
        $horas = $diferenca / 3600; // dividimos os segundos por 3600 para transformá-los em horas
        $dias = $diferenca / 86400; // dividimos os segundos por 86400 para transformá-los em dias
// abaixo fazemos verificações para definir a mensagem a ser mostrada.
        if ($minutos < 1) { // se a tiver passado de 0 a 60 segundos
            $diferenca = "há alguns segundos.";
        } elseif ($minutos > 1 && $horas < 1) { // se tiver passado de 1 a 60 minutos
            if (floor($minutos) == 1 or floor($horas) == 1) {
                $s = '';
            } else {
                $s = 's';
            } // plural ou singular de minuto
            $diferenca = "há " . floor($minutos) . " minuto" . $s;
        } elseif ($horas <= 24) { // se tiver passado de 1 a 24 horas
            if (floor($horas) == 1) {
                $s = '';
            } else {
                $s = 's';
            } // plural ou singular de hora
            $diferenca = "há " . floor($horas) . " hora" . $s;
        } elseif ($dias <= 2) { // se tiver passado um dia
            $diferenca = "ontem";
        } elseif ($dias <= 7) { // se tiver passado 6 dias
            $diferenca = "há " . floor($dias) . " dias";
        } elseif ($dias <= 8) { // se tiver passado uma semana (7 dias)
            $diferenca = "há uma semana";
        } else {
            $diferenca = date("d/m/Y", $data_banco);
        }
        return $diferenca; // mostramos a mensagem com a diferença de tempo
    }

    /**
     * Retorna a data por Extenso no padrão brasileiro
     * @return string 
     */
    public function getLongPtBr() {
        return $this->getDay() . ' de ' . $this->getMonthName() . ' de ' . $this->getYear();
    }

    /**
     * Retorna o valor da hora do instante atual.
     * @return integer
     */
    public function getHoursString() {
        return $this->format('H:i:s');
    }

    /**
     * Retorna a data de Nascimento de acordo com o parâmetro passado baseado
     * na data atual
     * @param type $dataNascimento 
     * @return int $ano
     */
    public static function getAge($dataNascimento) {
        $date = new Datetime($dataNascimento);
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

}
