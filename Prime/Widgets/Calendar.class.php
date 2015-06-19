<?php

namespace Prime\Widgets;

use Prime\DataTypes\TDatetime,
    Prime\Html\Table\HTMLTable;

/**
 * Classe que gera um calendario. Pode ser perfeitamente
 * configurável e até mesmo receber uma imagem a fim de fazer
 * um calendário personalizado pra web ou imprimir e por na parede
 * na mesa
 * @package Prime\Widgets
 */
class Calendar extends TDatetime {

// variaveis de acesso de  classe
// variables to hold current month, day and year
    private $currYear;
    private $currMonth;
    private $currDay;
    private $picture = "";
    private $info = "";

    // constructor
    /**
     * @param string $year
     * @param string $month
     */
    public function Calendar($year = null, $month = null) {
        date_default_timezone_set("Brazil/East");
        // current values
        $year = (is_null($year)) ? date("Y") : $year;
        $month = (is_null($month)) ? date("m") : $month;
        $this->currYear = $year;
        $this->currMonth = $month;
        $this->currDay = date("j");
        // verifica se � ano bisexto, modifica o vetor $totalDays
        if (date("L", mktime(0, 0, 0, $this->currMonth, 1, $this->currYear))) {
            $this->totalDays[2] = 29;
        }
    }

    private function CSSTable() {
        $cssStyle = "";
        $cssStyle.="border: 1px none white;";
        $cssStyle.="font-family:Courier New;";
        $cssStyle.="font-size:11px;";
        //$cssStyle.="background-color:#b9dddd;";
        $cssStyle.="padding:1px;";
        $cssStyle.="width:70%;";
        $cssStyle.="height:70%;";
        $cssStyle.=" '";
        return $cssStyle;
    }

    private function CSSCurrentDate() {
        $cssStyle = "";
        $cssStyle.="border: 0px solid #ffffff;";
        $cssStyle.="font-family:Courier New;";
        $cssStyle.="font-size:11px;";
        $cssStyle.="padding:1px;";
        $cssStyle.="background-color:#EEEEEE;";
        $cssStyle.="'";
        return $cssStyle;
    }

    /**
     * Retorna o calendário do mes passado como parâmetro
     * @param int $month Número do mês 
     * @return HTMLTable
     *
     */
    public function getMonth($month = null) {
        $this->currMonth = (is_null($month)) ? $this->currMonth : $month;
        $rowCount = 0;
        // descobre qual dia da semana eh o primeiro dia do mes
        $firstDayOfMonth = date("w", mktime(0, 0, 0, $this->currMonth, 1, $this->currYear));
        $table = new HTMLTable();
        $table->setAttribute('style', $this->CSSTable());
        $table->setAttribute('cellspacing', 1);

        $head = $table->insertRow();

        $header = $head->insertCell($this->months[$this->currMonth] . "-" . $this->currYear);
        $header->setAttribute('colspan', 7);
        $header->setAttribute('align', 'center');
        $header->setAttribute('background-color', '#9CC99C');
        $header->setAttribute('font-weight', 'bold');

        $semana = $table->insertRow();
        // grava nomes dos dias da semana
        for ($x = 0; $x < 7; $x++) {
            $sem = $semana->insertCell("<b>" . substr($this->days[$x], 0, 3) . "</b>");
            $sem->setStyle('text-align', 'center');
        }
        // inicia a impressao de data
        $dias = $table->insertRow();
        // mostra espacos em branco ate o primeiro dia do mes;
        for ($x = 1; $x <= $firstDayOfMonth; $x++) {
            // Usado para descobrir o final do bloco de 7 dias da semana
            $rowCount++;
            $dias->insertCell('');
        }
        // contador para descobrir a data atual
        $dayCount = 1;
        while ($dayCount <= $this->totalDays[$this->currMonth]) {
            $colorWday = "#CCDDCC";
            // descobre quando chegou o ultimo dia da semana e cria nova linha
            if ($rowCount % 7 == 0) {
                $dias = $table->insertRow();
                $colorWday = "#FFAAAA";
            }
            // grava a data, colora o dia atual de hoje
            if ($dayCount == date("j") &&
                    $this->currYear == date("Y") &&
                    $this->currMonth == date("n")) {
                $data = $dias->insertCell($dayCount);
                $data->setAttribute('align', 'center');
                $data->setAttribute('Style', $this->CSSCurrentDate());
            } else {
                $data = $dias->insertCell($dayCount);
                $data->setAttribute('bgcolor', $colorWday);
                $data->setAttribute('align', 'center');
            }
            // incrementa contadores
            $dayCount++;
            $rowCount++;
        }
        return $table->getOutput();
    }

    /**
     * formata um calendario completo do ano solicitado
     *
     * @return string
     */
    public function getCalendar() {
        $yearTable = "";
        $yearTable.="<table " . $this->CSSTable() . ">";
        $yearTable.="<caption>CALENDÁRIO " . $this->currYear . "</caption>";
        $yearTable.="<tr>";
        for ($month = 1; $month <= 12; $month++) {
            $this->currMonth = $month;
            $yearTable.="<td align='center' valign='top'>" . $this->getMonth() . "</td>";
            if ($month == 4 || $month == 6 || $month == 8) {
                $yearTable.="</tr><tr>";
            }
            if ($month == 5) {
                $yearTable.= "</td><td align='center' valign='top' rowspan='2' colspan='2'>";
                $yearTable.= $this->info . $this->getPicture() . "</td>";
            }
        }

        $yearTable.="</td></tr></table>";
        return $yearTable;
    }

    public function displayCalendar() {
        echo $this->getCalendar();
    }

    public function setTextInfo($txt) {
        if (!is_null($txt)) {
            $this->info = $txt;
        }
        return $this->info;
    }

    public function setPicture($path) {
        if (!is_null($path)) {
            $this->picture = "<img src='" . $path . "' border='0' width='100%' height='100%'>";
        }
        return $this->picture;
    }

    private function getPicture() {
        return $this->picture;
    }

// end of class
}

