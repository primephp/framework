<?php

namespace Prime\Html\Base;

/**
 * Uma classe usada para gerar caixas de selecao
 * para data, dias, meses, anso, hora, minuto, segundos
 * e comparar valores provenientes de fontes externas
 * para marcar como selecionado.
 */
class HTMLTimeCombobox
{

    private static $meses;

    public function __construct()
    {
        date_default_timezone_set("America/Sao_Paulo");
        self::$meses[] = "Janeiro";
        self::$meses[] = "Fevereiro";
        self::$meses[] = "Março";
        self::$meses[] = "Abril";
        self::$meses[] = "Maio";
        self::$meses[] = "Junho";
        self::$meses[] = "Julho";
        self::$meses[] = "Agosto";
        self::$meses[] = "Setembro";
        self::$meses[] = "Outubro";
        self::$meses[] = "Novembro";
        self::$meses[] = "Dezembro";
    }

    /**
     * Enter description here...
     *
     * @param string $e
     * @return string
     */
    public function getDateOptions($e = "")
    {
        $option = new HTMLElement("option");
        $option->value = "null";
        $option->appendChild("Data");
        $opt = $option->getOutput();
        for ($d = 1; $d <= 31; $d++) {
            $opt .= $this->optionGenerator($d, $e);
        }
        return $opt;
    }

    /**
     *
     * @param string $e
     * @return string
     */
    public function getMonthOptions($e = "")
    {
        $option = new HTMLElement("option");
        $option->value = "null";
        $option->appendChild("M�s");
        $opt = $option->getOutput();
        for ($d = 1; $d <= 12; $d++) {
            $opt .= $this->optionGenerator($d, $e);
        }
        return $opt;
    }

    /**
     *
     * @param string $e
     * @return string
     */
    public function getLongMonthOptions($e = "")
    {
        $option = new HTMLElement("option");
        $option->value = "null";
        $option->appendChild("Mês");
        $opt = $option->getOutput();
        $e = (int) $e;
        for ($d = 1; $d <= 12; $d++) {
            $option = new HTMLElement("option");
            if ($d == $e) {
                $option->selected = "selected>";
            }
            $option->value = "$d";
            $option->appendChild(self::$meses[$d - 1]);
            $opt .= $option->getOutput();
        }
        return $opt;
    }

    /**
     *
     * @param string $e
     * @return string
     */
    public function getShortMonthOptions($e = "")
    {
        $option = new HTMLElement("option");
        $option->value = "null";
        $option->appendChild("M�s");
        $opt = $option->getOutput();
        $e = (int) $e;
        for ($d = 1; $d <= 12; $d++) {
            $option = new HTMLElement("option");
            if ($d == $e) {
                $option->selected = "selected>";
            }
            $option->value = "$d";
            $option->appendChild(strtoupper(substr(self::$meses[$d - 1], 0, 3)));
            $opt .= $option->getOutput();
        }
        return $opt;
    }

    /**
     *
     * @param string $e
     * @return string
     */
    public function getYearsOptions($e = "")
    {
        $option = new HTMLElement("option");
        $option->value = "null";
        $option->appendChild("Ano");
        $opt = $option->getOutput();
        for ($d = (date("Y") - 5); $d <= (2020); $d++) {
            $opt .= $this->optionGenerator($d, $e);
        }
        return $opt;
    }

    /**
     *
     * @param string $e
     * @return string
     */
    public function getHoursOptions($e = "")
    {
        $option = new HTMLElement("option");
        $option->value = "null";
        $option->appendChild("Hora");
        $opt = $option->getOutput();
        for ($d = 0; $d <= 23; $d++) {
            $opt .= $this->optionGenerator($d, $e);
        }
        return $opt;
    }

    /**
     *
     * @param string $e
     * @return string
     */
    public function getMinutesOptions($e = "")
    {
        $option = new HTMLElement("option");
        $option->value = "null";
        $option->appendChild("Min");
        $opt = $option->getOutput();
        for ($d = 0; $d < 60; $d++) {
            $opt .= $this->optionGenerator($d, $e);
        }
        return $opt;
    }

    /**
     *
     * @param mixed $instante
     * @param mixed $comparator
     * @return HTMLElement
     */
    private function optionGenerator($instante, $comparator)
    {
        $instante = ($instante < 10) ? "0" . $instante : $instante;
        $option = new HTMLElement("option");
        if ($instante == $comparator) {
            $option->selected = "selected";
        }
        $option->value = "$instante";
        $option->appendChild("$instante");
        return $option->getOutput();
    }

    /**
     * Gera um SELECT com o valor do mes em abreviado
     *
     * @param string $name
     * @return string
     */
    public function getSelectShortMonth($name = "shortMonth", $cmp = NULL, $autoDraw = FALSE)
    {
        if (!$cmp) {
            $cmp = date("m");
        }
        $select = new HTMLElement("select");
        $select->name = $name;
        $select->id = $name;
        $select->appendChild($this->getShortMonthOptions($cmp));
        return $this->autoDraw($select, $autoDraw);
    }

    /**
     * Gera um SELECT com o valo dor mes em abrevido
     * @param string $name
     * @param string $cmp
     * @param  boolean $autoDraw
     * @return mixed
     */
    public function getSelectLongMonth($name = "shortMonth", $cmp = NULL, $autoDraw = FALSE)
    {
        if (!$cmp) {
            $cmp = date("m");
        }
        $select = new HTMLElement("select");
        $select->name = $name;
        $select->id = $name;
        $select->appendChild($this->getLongMonthOptions($cmp));
        return $this->autoDraw($select, $autoDraw);
    }

    /**
     * Gera uma caisa de sele��o com a representa��o de anos.
     * @param string $name
     * @param string $cmp
     * @param  boolean $autoDraw
     * @return mixed
     */
    public function getSelectYear($name = "years", $cmp = NULL, $autoDraw = FALSE)
    {
        if (!$cmp) {
            $cmp = date("Y");
        }
        $select = new HTMLElement("select");
        $select->name = $name;
        $select->id = $name;
        $select->appendChild($this->getYearsOptions($cmp));
        return $this->autoDraw($select, $autoDraw);
    }

    /**
     * Gera um SELECT com os anos.
     * @param string $name
     * @param string $cmp
     * @param  boolean $autoDraw
     * @return mixed
     */
    public function getSelectMonth($name = "month", $cmp = NULL, $autoDraw = FALSE)
    {
        if (!$cmp) {
            $cmp = date("m");
        }
        $select = new HTMLElement("select");
        $select->name = $name;
        $select->id = $name;
        $select->appendChild($this->getMonthOptions($cmp));
        return $this->autoDraw($select, $autoDraw);
    }

    /**
     * Gera um SELECT com os anos.
     * 	 
     * @param string $name
     * @param string $cmp
     * @param  boolean $autoDraw
     * @return mixed
     */
    public function getSelectDate($name = "date", $cmp = NULL, $autoDraw = FALSE)
    {
        if (!$cmp) {
            $cmp = date("d");
        }
        $select = new HTMLElement("select");
        $select->name = $name;
        $select->id = $name;
        $select->appendChild($this->getDateOptions($cmp));
        return $this->autoDraw($select, $autoDraw);
    }

    /**
     * Gera uma caixa de sele��o com os valores representando as Horas
     * @param string $name
     * @param string $cmp
     * @param  boolean $autoDraw
     * @return mixed
     */
    public function getSelectHours($name = "hours", $cmp = NULL, $autoDraw = FALSE)
    {
        if (!$cmp) {
            $cmp = date("H");
        }
        $select = new HTMLElement("select");
        $select->name = $name;
        $select->id = $name;
        $select->appendChild($this->getHoursOptions($cmp));
        return $this->autoDraw($select, $autoDraw);
    }

    /**
     * Gera uma caixa de sele��o com os valores representando os minutos
     * @param string $name
     * @param string $cmp
     * @param  boolean $autoDraw
     * @return mixed
     */
    public function getSelectMinutes($name = "minutes", $cmp = NULL, $autoDraw = FALSE)
    {
        if (!$cmp) {
            $cmp = date("i");
        }
        $select = new HTMLElement("select");
        $select->name = $name;
        $select->id = $name;
        $select->appendChild($this->getMinutesOptions($cmp));
        return $this->autoDraw($select, $autoDraw);
    }

    /**
     * Gera uma caixa de sele��o com os valores representando os segundos
     * @param string $name
     * @param string $cmp
     * @param  boolean $autoDraw
     * @return mixed
     */
    public function getSelectSeconds($name = "seconds", $cmp = NULL, $autoDraw = FALSE)
    {
        if (!$cmp) {
            $cmp = date("s");
        }
        $select = new HTMLElement("select");
        $select->name = $name;
        $select->id = $name;
        $select->appendChild($this->getMinutesOptions($cmp));
        return $this->autoDraw($select, $autoDraw);
    }

    private function autoDraw($select, $autoDraw = FALSE)
    {
        if ($autoDraw === TRUE) {
            $select->printOut();
            return FALSE;
        }
        return $select->getOutput();
    }

}
