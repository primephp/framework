<?php

namespace Prime\Html\Base;

class HTMLDateOptions {

    private static $meses;

    public function __construct() {
        date_default_timezone_set("Brazil/East");
        //print_r(DateTimeZone::listAbbreviations());
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

    public function getDates($e = "") {
        $e = (empty($e)) ? date("d") : (int)$e;
        $options = new ArrayList();
        for ($d = 1; $d <= 31; $d++) {
            $d = ($d < 10) ? "0" . $d : $d;
            $option = new HTMLElement("option");
            if ($d == $e) {
                $option->selected = "selected";
            }
            $option->value = "$d";
            $option->appendChild("$d");
            $options->add($option);
        }
        return $options;
    }

    /**
     * Retorna um conjunto de op��es configurados com o m�s por extenso
     *
     * @param int $e
     * @return ArrayList de HTMLElement
     */
    public function getMonths($e = "") {
        $e = (empty($e)) ? date("m") : (int)$e;
        $options = new ArrayList();
        for ($d = 1; $d <= 12; $d++) {
            $option = new HTMLElement("option");
            $d = ($d < 10) ? "0" . $d : $d;
            if ($d == $e) {
                $option->selected = "selected";
            }
            $option->value = "$d";
            $option->appendChild("$d");
            $options->add($option);
        }
        return $options;
    }

    /**
     * Retorna um conjunto de op��es configurados com o m�s por extenso
     *
     * @param int $e
     * @return ArrayList
     */
    public function getLongMonths($e = "") {
        $e = (empty($e)) ? date("m") : (int)$e;
        $options = new ArrayList();
        for ($d = 1; $d <= 12; $d++) {
            $d = ($d < 10) ? "0" . $d : $d;
            $option = new HTMLElement("option");
            if ($d == $e) {
                $option->selected = "selected";
            }
            $option->value = "$d";
            $option->appendChild(self::$meses[$d - 1]);
            $options->add($option);
        }
        return $options;
    }

    /**
     *
     *
     * @param int $e
     * @return ArrayList
     */
    public function getShortMonths($e = "") {
        $e = (empty($e)) ? date("m") : (int)$e;
        $options = new ArrayList();
        for ($d = 1; $d <= 12; $d++) {
            $option = new HTMLElement("option");
            $d = ( $d < 10) ? "0" . $d : $d;
            if ($d == $e) {
                $option->selected = "selected";
            }
            $option->value = "$d";
            $option->appendChild(substr(self::$meses[$d - 1], 0, 3));
            $options->add($option);
        }
        return $options;
    }

    /**
     *
     *
     * @param int $e
     * @return ArrayList
     */
    public function getYears($e = "") {
        $e = (empty($e)) ? date("Y") : (int)$e;
        $options = new ArrayList();
        for ($d = ($e - 5); $d <= ($e + 10); $d++) {
            $option = new HTMLElement("option");
            $d = ( $d < 10) ? "0" . $d : $d;
            if ($d == $e) {
                $option->selected = "selected";
            }
            $option->value = "$d";
            $option->appendChild($d);
            $options->add($option);
        }
        return $options;
    }

    /**
     * @param int $e
     * @return ArrayList
     */
    public function getHours($e = "") {
        $e = (empty($e)) ? date("H") : (int)$e;
        $options = new ArrayList();
        for ($d = 0; $d <= 23; $d++) {
            $option = new HTMLElement("option");
            $d = ( $d < 10) ? "0" . $d : $d;
            if ($d == $e) {
                $option->selected = "selected";
            }
            $option->value = "$d";
            $option->appendChild($d);
            $options->add($option);
        }
        return $options;
    }

    /**
     *
     * @param int $e
     * @return ArrayList
     */
    public function getMinutes($e = "") {
        $e = (empty($e)) ? date("i") : (int)$e;
        $options = new ArrayList();
        for ($d = 0; $d <= 59; $d++) {
            $option = new HTMLElement("option");
            $d = ($d < 10) ? "0" . $d : $d;
            if ($d == $e) {
                $option->selected = "selected";
            }
            $option->value = "$d";
            $option->appendChild($d);
            $options->add($option);
        }
        return $options;
    }

}
