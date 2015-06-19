<?php

namespace Prime\DataTypes;

/**
 * @package Prime\DataTypes
 * @author
 * @access
 */
class TMoney {

    private $value;

    public function __construct($value = 0.0) {
        $this->changeValue($value);
    }

    /**
     * Formata um valor numerico para formato de dinheiro do Brasil
     *
     * @return string
     */
    public function getMoneyptBR() {
        setlocale(LC_ALL, "pt_BR.UTF8");
        $locale_info = localeconv();

        return "R$ " . number_format($this->value, 2, ',', '.');
    }

    /**
     * Formata um valor numerico para formato de dinheiro do americano
     *
     * @return string
     */
    public function getMoneyUsD() {
        /// setlocale(LC_ALL, "en_US");
        //$locale_info = localeconv();
        return substr(money_format('%i', $this->value), 4);
    }

    /**
     * Formata um valor numerico para formato de dinheiro do europeu (EUR)
     *
     * @return string
     */
    public function getMoneyEuro() {
        setlocale(LC_ALL, "pt_PT");
        $locale_info = localeconv();
        return substr(money_format('%i', $this->value), 4);
    }

    /**
     * Altera o valor interno a fim de formata-lo
     */
    public final function changeValue($value = 0.0) {
        if (strpos($value, ",")) {
            $value = str_replace(".", "", $value);
            $value = str_replace(",", ".", $value);
            $value = (float) $value;
        }

        if (is_numeric($value)) {
            $value = ((float) $value) + 0.0;
        }
        $this->value = is_float($value) ? $value : 0.0;
    }

    /**
     *
     * @return float;
     */
    public final function moneyToFloat() {
        return $this->value;
    }

}

