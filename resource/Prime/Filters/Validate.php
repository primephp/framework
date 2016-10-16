<?php

namespace Prime\Filters;

/**
 * Descrição da Classe Validate
 * @name Validate
 * @package Prime\Filters
 * @version 1.0
 * @author tom
 * @since 22/10/2011
 * @access public
 */
class Validate {

    /**
     * Retorna TRUE para "1", "true", "on" e "yes". Retorna FALSE caso contrário.
     * @param type $value
     * @return type 
     */
    public static function boolean($value) {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Valida valores de email
     * @param type $email
     * @return type 
     */
    public static function email($email) {
//        gethostbyname($hostname);
//        getmxrr($hostname, $mxhosts);
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Valida valores de float
     * @param type $float
     * @return type 
     */
    public static function float($float)
    {
    return filter_var($float, FILTER_VALIDATE_FLOAT);


    }

/**
 * Valida números inteiros
 * @param type $integer
 * @return type 
 */
public static function integer($integer) {
    return filter_var($integer, FILTER_VALIDATE_INT);
}

/**
 * Valida números de IP
 * @param type $ip
 * @return type 
 */
public static function ip($ip) {
    return filter_var($ip, FILTER_VALIDATE_IP);
}

/**
 * Valida o valor contra a regexp, uma expressão compatível com Perl regular.
 * @param type $value
 * @return type 
 */
public static function regexp($value) {
    return filter_var($value, FILTER_VALIDATE_REGEXP);
}

/**
 * Valida uma URL
 * @param type $url
 * @return type 
 */
public static function url($url) {
    return filter_var($url, FILTER_VALIDATE_URL);
}

/**
 * Valida uma data
 * Caso o segundo parâmetro seja definido como FALSE, 
 * é entendido que a data da passada será no padrão
 * brasileiro dia-mês-ano, do contrário o padrão é
 * americano year-mounth-day
 * @param data $date
 * @param boolean $is_usa
 * @return boolean 
 */
public static function date($date, $is_usa = true) {
    if (trim($sDate) == "") {
        return FALSE;
    }

    $sDate = split('[/.-]', $sDate);

    if ($is_usa == true) { // se foi passada no padrão americano
        if (!checkdate($sDate[1], $sDate[2], $sDate[0])) {
            return FALSE;
        } else {
            return TRUE;
        }
    } else { // do contrário acredita-se que vai ser passado no padrão brasileiro
        if (!checkdate($sDate[1], $sDate[0], $sDate[2])) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

}
