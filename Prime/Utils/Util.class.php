<?php

namespace Prime\Utils;

/**
 * Description of Util
 * @package Prime\Utils
 * @author TomSailor
 */
class Util {

    /**
     * Convierte la cadena con espacios o guión bajo en notacion camelcase
     *
     * @param string $s cadena a convertir
     * @param boolean $lower indica si es lower camelcase
     * @return string
     *
     */
    public static function camelCase($s, $lower = false) {

        $s = ucwords(strtolower(strtr($s, '_', ' ')));
        $s = str_replace(' ', '', $s);

        /**
         * Notacion lowerCamelCase
         * */
        if ($lower) {
            $s = self::lcfirst($s);
        }
        return $s;
    }

    /**
     * Remplaza en la cadena los espacios por dash (guiones)
     * @param string $s
     * @return string
     * */
    public static function dash($s) {
        return strtr($s, ' ', '-');
    }

    /**
     * Remplaza en una cadena los underscore o dashed por espacios
     * @param string $s
     * @return string
     * */
    public static function humanize($s) {
        return strtr($s, '_-', '  ');
    }

    /**
     * Coloca la primera letra en minuscula
     *
     * @param $s string cadena a convertir
     * @return string
     * */
    public static function lcfirst($s) {
        $s[0] = strtolower($s[0]);
        return $s;
    }

    /**
     * Remplaza en la cadena los espacios por guiónes bajos (underscores)
     * @param string $s
     * @return string
     * */
    public static function underscore($s) {
        return strtr($s, ' ', '_');
    }

    public static function analize() {
        $tempo_carregamento = mktime() - $_SERVER['REQUEST_TIME'];

        return "A página demorou {$tempo_carregamento} segundos para carregar.";
    }

}


