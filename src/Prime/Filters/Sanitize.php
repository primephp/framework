<?php

namespace Prime\Filters;

/**
 * Descrição da Classe Satinize
 * @name Sanatize
 * @package Prime\Filters
 * @version 1.0
 * @author Elton Luiz
 * @since 22/10/2011
 * @access public
 */
final class Sanitize
{

    /**
     * Remove todos caracteres exceto letras, dígitos e 
     * !#$%&'*+-/=?^_`{|}~@.[]. 
     * @param mixed $email
     * @return email 
     */
    public static function email($email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Remove todos caracteres exceto dígitos, + - e opcionalmente .,eE
     * @param mixed $float
     * @return TFloat 
     */
    public static function float($float)
    {
    return filter_var($float, FILTER_SANITIZE_NUMBER_FLOAT);




    }

/**
 * Remove todos caracteres exceto dígitos, mais e sinal de menos.
 * @param mixed $integer
 * @return integer 
 */
public static function integer($integer)
{
    return filter_var($integer, FILTER_SANITIZE_NUMBER_INT);
}

/**
 * Remove tag opcionalmente remove ou codifica caracteres especiais.
 * @param mixed $string
 * @return string 
 */
public static function string($string)
{
return filter_var($string, FILTER_SANITIZE_STRING);




    }

public static function letters($string)
{
return preg_replace("/[\s,.;:0123456789\'\"()]+/", '', $string);
}

/**
 * Remove todos os caracteres, exceto, letras, dígitos e 
 * $-_.+!*'(),{}|\\^~[]`<>#%";/?:@&=. 
 * @param mixed $url
 * @return Url 
 */
public static function url($url)
{
return filter_var($url, FILTER_SANITIZE_URL);
}

/**
 * HTML-escape-'"<>& e caracteres com valor ASCII menor que 32, 
 * opcionalmente remove ou codifica outros caracteres especiais.
 * @param mixed $chars
 * @return specialChars 
 */
public static function specialChars($chars)
{
return filter_var($chars, FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * Aplica addslashes(), adicionando barras de escape
 * @param mixed $quotes
 * @return magicQuotes 
 */
public static function magicQuotes($quotes)
{
return filter_var($quotes, FILTER_SANITIZE_MAGIC_QUOTES);
}

/**
 * URL-encode string, opcionalmente remove ou codifica caracteres especiais.
 * @param mixed $encoded
 * @return encoded 
 */
public static function encoded($encoded)
{
return filter_var($encoded, FILTER_SANITIZE_ENCODED);
}

}
