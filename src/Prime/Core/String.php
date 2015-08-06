<?php

namespace Prime\Core;

use InvalidArgumentException;

final class String extends Object
{

    public function __construct($string = NULL)
    {
        $this->setEncoding('UTF8');
        if (!is_null($string)) {
            $this->setValue($string);
        }
    }

    /**
     * Este método retorna uma String que representa a seqüência de 
     * caracteres passado como parâmetro  
     * @param string $str
     * @return String
     */
    public static function create($str)
    {
        return new String($str);
    }

    /**
     * Retorna a própria instância de String pronta para ser manipulada ou 
     * impressa
     * @return String
     */
    public function toString()
    {
        return $this;
    }

    /**
     * Retorna a string do objeto
     * @return string
     */
    public function __toString()
    {
        return $this->getValue();
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
        return $this->data['value'];
    }

    /**
     * Supondo que a especificada string representa uma cadeia de caracteres, 
     * retorna um novo objeto String inicializado pelo valor passado
     * @param str $str
     * @return String
     */
    public static function valueOf($str)
    {
        return new String($str);
    }

    /**
     * Define o conteúdo da String
     * @param string $value
     * @throws InvalidArgumentException
     */
    private function setValue($value)
    {
        if (is_string($value)) {
            $this->data['value'] = filter_var($value, FILTER_SANITIZE_STRING);
            $this->data['length'] = $this->length();
        } else {
            throw new InvalidArgumentException(__CLASS__ . ' aceita apenas '
            . 'strings. Valor inválido passado: ' . $value);
        }
    }

    /**
     * Retorna a codificação de caracteres da string
     * @return string 
     */
    public function getEncoding()
    {
        return $this->data['encoding'];
    }

    /**
     * Define a codificação de caracteres da string
     * @param string $encoding
     */
    public function setEncoding($encoding)
    {
        $this->data['encoding'] = $encoding;
    }

    /**
     * Compara a string de dois objetos String
     * @param String $str
     * @return Boolean Caso as string sejam iguais retorna TRUE do contrário
     * retorna FALSE
     */
    public function compareTo(String $str)
    {
        if ($this->getValue() === $str->getValue()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Compara a string de dois objetos String ignorando caixa alta e caixa
     * baixa
     * @param String $str
     * @return Boolean
     */
    public function compareToIgnoreCase(String $str)
    {
        if ($this->toUpper()->getValue() === $str->toUpper()->getValue()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Concatena a seqüência especificada para o final desta string.
     * @param String $str
     * @return String
     */
    public function concat(String $str)
    {
        $this->setValue($this->getValue() . $str->getValue());
        return $this;
    }

    /**
     * Retorna true se e somente se esta string contém a seqüência 
     * especificada de valores char.
     * @param char $s
     * @return Boolean
     */
    public function contains($s)
    {
        return (bool) mb_strstr($this->getValue(), $s, FALSE, $this->getEncoding());
    }

    /**
     * Retorna uma nova String que é uma substring desta string. 
     * @param int $beginIndex
     * @param int $length
     * @return String
     */
    public function subString($beginIndex, $length)
    {
        return new String(mb_substr($this->getValue(), $beginIndex, $length, $this->getEncoding()));
    }

    /**
     * Encontra a posição da primeira ocorrência de uma string dentro de outra,
     * sem diferenciar maiúsculas e minúsculas
     * @param type $needle A string a ser localizada no objeto String corrente
     * @param type $offset A posição que vai ser iniciar a busca da string
     * @return int
     */
    public function insensitivePosition($needle, $offset = 0)
    {
        return mb_stripos($this->getValue(), $needle, $offset, $this->getEncoding());
    }

    /**
     * Encontra a posição da primeira ocorrência de uma string dentro de outra,
     * diferenciando maiúsculas e minúsculas
     * @param type $needle A string a ser localizada no objeto String corrente
     * @param type $offset A posição que vai ser iniciar a busca da string
     * @return int
     */
    public function sensitivePosition($needle, $offset = 0)
    {
        return mb_stripos($this->getValue(), $needle, $offset, $this->getEncoding());
    }

    /**
     * Remove os principais espaços em branco e omitido.
     * @return String
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
     * @return String 
     */
    public function replace($pattern, $replacement)
    {
        $this->setValue(mb_ereg_replace($pattern, $replacement, $this->getValue()));
        return $this;
    }

    /**
     * Converte todos os caracteres alfabéticos para maiúsculo. 
     * @return String
     */
    public function toUpper()
    {
        $this->setValue(mb_strtoupper($this->getValue(), $this->getEncoding()));
        return $this;
    }

    /**
     * Converte todos os caracteres alfabéticos para minúsculos. 
     * @return String
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
     * @return String
     */
    public function strimWidth($width, $start = 0, $trimMarker = '')
    {
        $this->setValue(mb_strimwidth($this->getValue(), $start, $width, $trimMarker, $this->getEncoding()));
        return $this;
    }

}
