<?php

namespace Prime\Core;

use Prime\Core\Exceptions\InvalidParamException;
use Prime\Core\Interfaces\StringInterface;
use function mb_convert_encoding;
use function mb_stripos;
use function mb_stristr;
use function mb_strlen;
use function mb_strpos;
use function mb_strrchr;
use function mb_strrichr;
use function mb_strstr;
use function mb_strtolower;
use function mb_strtoupper;
use function mb_strwidth;
use function mb_substr;
use function mb_substr_count;

final class TString extends TObject implements StringInterface
{

    /**
     * Índice do array onde é armazenado a string
     * @var string
     */
    private static $VALUE = 'value';

    /**
     * Índice do array onde é armazenado o tamanho da string
     * @var string
     */
    private static $LENGTH = 'length';

    /**
     * Índice do array onde é armazenado o encoding da string
     * @var string
     */
    private static $ENCODING = 'encoding';

    public function __construct($string = NULL)
    {
        $this->setEncoding('UTF8');
        $this->setLength();
        $this->setValue('');
        if (!is_null($string)) {
            $this->setValue($string);
        }
    }

    private function setLength($size = 0)
    {
        $this->data[self::$LENGTH] = $size;
    }

    /**
     * Este método retorna uma String que representa a seqüência de 
     * caracteres passado como parâmetro  
     * @param string $str
     * @return TString
     */
    public static function create($str)
    {
        return new TString($str);
    }

    /**
     * Retorna a própria instância de String pronta para ser manipulada ou 
     * impressa
     * @return string
     */
    public function toString()
    {
        return (string) $this->getValue();
    }

    /**
     * Retorna a string do objeto
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Retorna true se, e somente se, length() é 0.
     * @return boolean
     */
    public function isEmpty()
    {
        if (!$this->length()) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Remove qualquer tipo de tag e deixa a string pura
     * @param string $string
     * @return TString
     */
    public static function sanitize($string)
    {
        $v = filter_var($string, FILTER_SANITIZE_STRING);
        return new TString($v);
    }

    /**
     * Retorna o total de caracteres da string
     * @return int
     */
    public function length()
    {
        return mb_strlen($this->getValue(), $this->getEncoding());
    }

    /**
     * Largura de retorno de string
     * @return int
     */
    public function width()
    {
        return mb_strwidth($this->getValue(), $this->getEncoding());
    }

    /**
     * Retorna um array com o total de vezes que cada caracter surge na string
     * passada como parâmetro
     * @param string $input
     * @return array
     */
    public function countChars($input)
    {
        $l = mb_strlen($input, $this->getEncoding());
        $unique = [];
        for ($i = 0; $i < $l; $i++) {
            $char = mb_substr($input, $i, 1, $this->getEncoding());
            if (!array_key_exists($char, $unique)) {
                $unique[$char] = 0;
            }
            $unique[$char] ++;
        }
        return $unique;
    }

    /**
     * Retorna o conteúdo da string
     * @return string a string interna armazenada
     */
    public function getValue()
    {
        return $this->data[self::$VALUE];
    }

    /**
     * Supondo que a especificada string representa uma cadeia de caracteres, 
     * retorna um novo objeto String inicializado pelo valor passado
     * @param str $str
     * @return TString
     */
    public static function valueOf($str)
    {
        return new TString($str);
    }

    /**
     * Define o valor da string
     * @param string $value
     * @throws InvalidParamException Caso seja passado um tipo diferente de
     * string
     */
    private function setValue($value)
    {
        if (is_string($value)) {
            $this->data[self::$VALUE] = $value;
            $this->data[self::$LENGTH] = $this->length();
        } else {
            throw new InvalidParamException(__CLASS__ . ' aceita apenas '
            . 'strings. Valor inválido passado: ' . $value);
        }
    }

    /**
     * Retorna a codificação de caracteres da string
     * @return string 
     */
    public function getEncoding()
    {
        return $this->data[self::$ENCODING];
    }

    /**
     * Define a codificação de caracteres da string
     * @param string $encoding
     */
    public function setEncoding($encoding)
    {
        $this->data[self::$ENCODING] = $encoding;
    }

    /**
     * Compara a string de dois objetos String
     * @param string $str
     * @return boolean Caso as string sejam iguais retorna TRUE do contrário
     * retorna FALSE
     */
    public function compareTo($str)
    {
        if (!$str instanceof TString) {
            $str = new TString((string) $str);
        }
        if ($this->getValue() === $str->getValue()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Compara a string de dois objetos String ignorando caixa alta e caixa
     * baixa
     * @param string $str
     * @return TBoolean
     */
    public function compareToIgnoreCase($str)
    {
        if (!$str instanceof TString) {
            $str = new TString((string) $str);
        }
        if ($this->toUpper()->getValue() === $str->toUpper()->getValue()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Concatena a seqüência especificada para o final desta string.
     * @param string $str
     * @return TString
     */
    public function concat($str)
    {
        if (!$str instanceof TString) {
            $str = new TString((string) $str);
        }
        $this->setValue($this->getValue() . $str->getValue());
        return $this;
    }

    /**
     * Retorna true se e somente se esta string contém a seqüência 
     * especificada de valores char.
     * @param char $s
     * @return TBoolean
     */
    public function contains($s)
    {
        return (bool) mb_strstr($this->getValue(), $s, FALSE, $this->getEncoding());
    }

    /**
     * Retorna uma nova instância de String que é uma substring desta string. 
     * @param int $beginIndex
     * @param int $length
     * @return TString
     */
    public function subString($beginIndex, $length)
    {
        return new TString(mb_substr($this->getValue(), $beginIndex, $length, $this->getEncoding()));
    }

    /**
     * Encontra a posição da primeira ocorrência de uma string dentro de outra,
     * sem diferenciar maiúsculas e minúsculas
     * @param string $needle A string a ser localizada no objeto String corrente
     * @param int $offset A posição que vai ser iniciar a busca da string
     * @return int
     */
    public function iPosition($needle, $offset = 0)
    {
        return mb_stripos($this->getValue(), $needle, $offset, $this->getEncoding());
    }

    /**
     * Encontra a posição da primeira ocorrência de uma string dentro de outra,
     * diferenciando maiúsculas e minúsculas
     * @param string $needle A string a ser localizada no objeto String corrente
     * @param int $offset A posição que vai ser iniciar a busca da string
     * @return int
     */
    public function sensitivePosition($needle, $offset = 0)
    {
        return mb_stripos($this->getValue(), $needle, $offset, $this->getEncoding());
    }

    /**
     * Remove os principais espaços em branco e omitido.
     * @return TString
     */
    public function trim()
    {
        $this->setValue(trim($this->getValue()));
        return $this;
    }

    /**
     * Procura a primeira ocorrência de uma string dentro de String
     * @param string $needle
     * @param int $offset
     * @return int o index da posição da string passada
     */
    public function indexOf($needle, $offset = 0)
    {
        return mb_strpos($this->getValue(), $needle, $offset, $this->getEncoding());
    }

    /**
     * Substitui um carater ou uma cadeia de caracteres dentro de String
     * @param string $pattern string a ser substituída
     * @param string $replacement string que substituirá os valores encontrados
     * @return TString 
     */
    public function replace($pattern, $replacement)
    {
        $this->setValue(mb_ereg_replace($pattern, $replacement, $this->getValue()));
        return $this;
    }

    /**
     * Converte todos os caracteres alfabéticos para maiúsculo. 
     * @return TString
     */
    public function toUpper()
    {
        $this->setValue(mb_strtoupper($this->getValue(), $this->getEncoding()));
        return $this;
    }

    /**
     * Converte todos os caracteres alfabéticos para minúsculos. 
     * @return TString
     */
    public function toLower()
    {
        $this->setValue(mb_strtolower($this->getValue(), $this->getEncoding()));
        return $this;
    }

    /**
     * Retorna um array dos caracteres que formam a String
     * @return array
     */
    public function toArray()
    {
        $string = $this->getValue();
        $strlen = mb_strlen($string);
        $array = [];
        while ($strlen) {
            $array[] = mb_substr($string, 0, 1, $this->getEncoding());
            $string = mb_substr($string, 1, $strlen, $this->getEncoding());
            $strlen = mb_strlen($string);
        }
        return $array;
    }

    /**
     * Trunca a string com uma largura especificada
     * @param int $width A largura da string desejada.
     * @param int $start Posição inicial
     * @param string $trimMarker Uma seqüência que é adicionado ao final da string quando a string é truncada. 
     * @return TString
     */
    public function strimWidth($width, $start = 0, $trimMarker = '')
    {
        $this->setValue(mb_strimwidth($this->getValue(), $start, $width, $trimMarker, $this->getEncoding()));
        return $this;
    }

    /**
     * Busca a última ocorrência de uma string
     * @param string $str A string a ser localizada
     * @param boolean $part Define qual parte da string será retornada<br>
     * Caso seja <b>TRUE</b> retornará toda a string até o início da última 
     * ocorrência de $char <br>
     * Caso seja <b>FALSE</b> retornará toda a string a partir da última 
     * ocorrência de $char
     * @return TString|boolean Retorna um objeto String contendo o conteúdo de acordo com
     * o parâmetro $before_char ou <b>false</b> caso não seja encontrada nenhuma ocorrência
     */
    public function lastOccurrence($str, $part = false)
    {
        $r = mb_strrchr($this->getValue(), $str, $part, $this->getEncoding());
        if ($r) {
            return new TString($r);
        } else {
            return false;
        }
    }

    /**
     * Busca a última ocorrência de uma string (Case Insensitive)
     * @param string $str A string a ser localizada
     * @param boolean $before_char Define qual parte da string será retornada<br>
     * Caso seja <b>TRUE</b> retornará toda a string até o início da última 
     * ocorrência de $char <br>
     * Caso seja <b>FALSE</b> retornará toda a string a partir da última 
     * ocorrência de $char
     * @return TString|boolean Retorna um objeto String contendo o conteúdo de acordo com
     * o parâmetro $before_char ou <b>false</b> caso não seja encontrada nenhuma ocorrência
     */
    public function iLastOccurrence($str, $before_char = false)
    {
        $r = mb_strrichr($this->getValue(), $str, $before_char, $this->getEncoding());
        if ($r) {
            return new TString($r);
        } else {
            return false;
        }
    }

    /**
     * Busca a primeira ocorrência de um caracter na string
     * @param TString $char A string a ser localizada
     * @param boolean $before_char Define qual parte da string será retornada<br>
     * Caso seja <b>TRUE</b> retornará toda a string até o início da primeira 
     * ocorrência de $char <br>
     * Caso seja <b>FALSE</b> retornará toda a string a partir da primeira 
     * ocorrência de $char
     * @return TString|boolean Retorna um objeto String contendo o conteúdo de acordo com
     * o parâmetro $before_char ou <b>false</b> caso não seja encontrada nenhuma ocorrência
     */
    public function firstOccurrence($char, $before_char = false)
    {
        $r = mb_strstr($this->getValue(), $char, $before_char, $this->getEncoding());
        if ($r) {
            return new TString($r);
        } else {
            return false;
        }
    }

    /**
     * Busca a primeira ocorrência de um caracter na string (Case Insensitive)
     * @param string $char A string a ser localizada
     * @param boolean $before_char Define qual parte da string será retornada<br>
     * Caso seja <b>TRUE</b> retornará toda a string até o início da primeira 
     * ocorrência de $char <br>
     * Caso seja <b>FALSE</b> retornará toda a string a partir da primeira 
     * ocorrência de $char
     * @return TString|boolean Retorna um objeto String contendo o conteúdo de acordo com
     * o parâmetro $before_char ou <b>false</b> caso não seja encontrada nenhuma ocorrência
     */
    public function iFirstOccurrence($char, $before_char = false)
    {
        $r = mb_stristr($this->getValue(), $char, $before_char, $this->getEncoding());
        if ($r) {
            return new TString($r);
        } else {
            return false;
        }
    }

    /**
     * Obtem uma String truncada com a largura especificada
     * @param int $start O índice do caracter onde começará a string
     * @param int $width A largura da string desejada
     * @param string $trimmarker A string que será adicionada no final da string
     * truncada
     * @return TString Retorna um objeto string contendo a string truncada, caso
     * seja passado $trimmarker, esse será adicionado no seu fina.
     */
    public function trimWidth($start, $width, $trimmarker = NULL)
    {
        $r = mb_strimwidth($this->getValue(), $start, $width, $trimmarker, $this->getEncoding());
        return new TString($r);
    }

    /**
     * Retorna o total de ocorrências encontradas 
     * @param string $str A string a ser localizada no objeto
     * @return int O total de ocorrências encontradas
     */
    public function countOccurrence($str)
    {
        return mb_substr_count($this->getValue(), $str, $this->getEncoding());
    }

    /**
     * Altera a codificação de caracteres
     * @param string $encoding
     */
    public function convertEncoding($encoding)
    {
        $this->setValue(mb_convert_encoding($this->getValue(), $encoding, $this->getEncoding()));
        $this->setEncoding($encoding);
    }

}
