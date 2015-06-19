<?php

namespace Prime\DataTypes;

define("STR_REDUCE_LEFT", 1);
define("STR_REDUCE_RIGHT", 2);
define("STR_REDUCE_CENTER", 4);

/**
 * Descrição da Classe StringType
 * @name StringType
 * @package Prime\DataTypes
 * @version 1.0
 * @author TomSailor
 * @since 18/08/2011
 * @access public
 */
class TString extends StdType {

    /**
     * Método concat
     * Concatena a String com o valor passado
     * @param mixed $string Valor a ser concatenado
     */
    public function concat($string) {
        if ($string instanceof TString) {
            $string = $string->getValue();
        }
        $this->value .= $string;
    }

    /**
     * Compara se a String é igual 
     * @param TString $anotherString
     * @return boolean
     */
    public function compareTo(TString $anotherString) {
        if ($this->getValue() === $anotherString->getValue()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function contentEquals($string) {
        if ($string == $this->value) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function copyValueOf($string) {
        
    }

    public function endsWith(TString $string) {
        
    }

    public function equals(TObject $anObject) {
        
    }

    public function equalsIgnoreCase(TObject $anObject) {
        
    }

    public static function format($locale, $format) {
        
    }

    public function getBytes() {
        
    }

    public function hashCode() {
        return hash('sha512', $this->value);
    }

    public function indexOf($char) {
        
    }

    public function isEmpty() {
        if (!count_chars($this->value))
            return TRUE;
        return FALSE;
    }

    public function lastIndexOf($char) {
        
    }

    /**
     * Retorna TRUE se e se somente se o conteúdo do objeto contém a str passada
     * como parâmetro
     * @param type $string
     * @return bool
     */
    public function contains($string) {
        return strstr($this->value, $string);
    }

    /**
     * Compara se a String é igual ignorando maísculas e minúsculas
     * @param TString $anotherString
     * @return boolean
     */
    public function compareToIgnoreCase(TString $anotherString) {
        if (TString::strtolower_utf8($this->getValue()) === TString::strtolower_utf8($anotherString->getValue())) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Método subString
     * Retorna uma sub string de acordo com os parâmetros passados
     * @param int $start início da substring
     * @param int $length tamanho
     * @return TString 
     */
    public function subString($start, $length = null) {
        return new TString(substr($this->value, $start, $length));
    }

    /**
     * Método position
     * Retorna a posição da String passada como parâmetro dentro da valor
     * do objeto String
     * @param str $string
     * @param type $offset
     * @return type 
     */
    public function position($string, $offset = null) {
        return strpos($this->getValue(), $string, $offset);
    }

    /**
     * Método Replace
     * @param str $search A seqüência de caracteres ou matriz que está 
     * sendo pesquisada e substituído
     * @param str $replace O valor de substituição que substitui os valores 
     * de sua procura. Uma matriz pode ser usado para designar várias substituições.
     * @return TString
     */
    public function replace($search, $replace) {
        return new TString(str_replace($search, $replace, $this->value));
    }

    /**
     * Retorna o valor do caracter no índice especificado 
     * @param int $index
     * @return char
     */
    public function chatAt($index) {
        $value = utf8_encode($this->value);

        return $value[(int) $index];
    }

    /**
     * Método getCutString
     * Pega um pedaço da String de acordo com os parâmetros passados
     * @param int $size tamanho da String
     * @param int $start início da sub-string
     * @param str $str_end String a ser adicionada ao final da string
     * @return TString 
     */
    public function getCutString($word, $words_before = 10, $words_after = 10) {
        $s = $this->explode();
        $k = $this->iSearch($word);
        $size = count($s);
        $words_before = $k - $words_before;
        $words_after = $words_after + $k;

        $string = '';
        for ($index = $words_before; $index < $words_after + 1; $index++) {
            if (!empty($s[$index])) {
                $string .= $s[$index] . ' ';
            } else {
                $words_after = $index;
            }
        }
        if (!empty($string)) {
            $string = '...' . $string . '...';

            return $string;
        } else {
            return $this->value;
        }
    }

    public function iSearch($value) {
        $value = self::normalize($value);

        $array = $this->split();
        foreach ($array as $fat) {
            $splited[] = self::normalize($fat);
        }

        return array_search($value, $splited);
    }

    public function count() {
        return str_word_count($this->getValue());
    }

    public function explode($delimiter = " ") {
        return explode($delimiter, $this->value);
    }

    public function reduce_total_words($totalWords) {
        $words = explode(' ', $this->getValue());
        $total = count($words);

        if ($total > $totalWords) {
            $string = '';
            for ($index = 0; $index < $totalWords; $index++) {
                $string .= $words[$index] . ' ';
            }
            return new TString($string . '...');
        } else {
            return new TString(implode(' ', $words));
        }
    }

    /**
     * Método split <br/>
     * 
     * @return type 
     */
    public function split() {
        return preg_split("/[\s,.;:\'\"()]+/", $this->getValue());
    }

    public function removeAccents($charset = 'UTF8', $remove_spaces = FALSE) {
        $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';

        if ($charset == 'UTF8') {
            $string = utf8_decode($this->getValue());
            $string = strtr($string, utf8_decode($a), $b); //substitui letras acentuadas por "normais"
        } else {
            $string = strtr($string, $a, $b); //substitui letras acentuadas por "normais"
        }

        if ($remove_spaces) {
            $string = str_replace(" ", "", $string); // retira espaco
        }

        if ($charset == 'UTF8') {
            return utf8_encode($string);
        } else {
            return $string;
        }
    }

    public static function normalize($string) {
        $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $string = utf8_decode($string);
        $string = strtr($string, utf8_decode($a), $b); //substitui letras acentuadas por "normais"
        //$string = str_replace(" ", "", $string); // retira espaco
        $string = strtolower($string); // passa tudo para minusculo
        return utf8_encode($string); //finaliza, gerando uma saída para a funcao
    }

    /**
     * Para limpeza da string Removendo caracteres especiais
     * Acentos, espaços
     * @param type $string 
     */
    public static function cleaner($string) {
        $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $string = utf8_decode($string);
        $string = strtr($string, utf8_decode($a), $b); //substitui letras acentuadas por "normais"
        $string = str_replace(' ', '_', $string);
        return $string;
    }

    public static function strtolower_utf8($string) {
        $convert_to = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u",
            "v", "w", "x", "y", "z", "à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë", "ì", "í", "î", "ï",
            "ð", "ñ", "ò", "ó", "ô", "õ", "ö", "ø", "ù", "ú", "û", "ü", "ý", "а", "б", "в", "г", "д", "е", "ё", "ж",
            "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы",
            "ь", "э", "ю", "я"
        );
        $convert_from = array(
            "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U",
            "V", "W", "X", "Y", "Z", "À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "È", "É", "Ê", "Ë", "Ì", "Í", "Î", "Ï",
            "Ð", "Ñ", "Ò", "Ó", "Ô", "Õ", "Ö", "Ø", "Ù", "Ú", "Û", "Ü", "Ý", "А", "Б", "В", "Г", "Д", "Е", "Ё", "Ж",
            "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ъ", "Ъ",
            "Ь", "Э", "Ю", "Я"
        );
        return str_replace($convert_from, $convert_to, $string);
    }

    public static function strtoupper_utf8($string) {
        $convert_from = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u",
            "v", "w", "x", "y", "z", "à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë", "ì", "í", "î", "ï",
            "ð", "ñ", "ò", "ó", "ô", "õ", "ö", "ø", "ù", "ú", "û", "ü", "ý", "а", "б", "в", "г", "д", "е", "ё", "ж",
            "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы",
            "ь", "э", "ю", "я"
        );
        $convert_to = array(
            "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U",
            "V", "W", "X", "Y", "Z", "À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "È", "É", "Ê", "Ë", "Ì", "Í", "Î", "Ï",
            "Ð", "Ñ", "Ò", "Ó", "Ô", "Õ", "Ö", "Ø", "Ù", "Ú", "Û", "Ü", "Ý", "А", "Б", "В", "Г", "Д", "Е", "Ё", "Ж",
            "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ъ", "Ъ",
            "Ь", "Э", "Ю", "Я"
        );
        return str_replace($convert_from, $convert_to, $string);
    }

}

