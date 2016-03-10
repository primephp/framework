<?php

namespace Prime\Security;

use Prime\Core\TObject;

/**
 * Classe utilizada para criptografia de dados, sendo utilizada um chave para 
 * criptografar
 * @name Secret
 * @package Prime\Security
 * @version 1.0
 * @author TomSailor
 * @since 25/08/2015
 * @access public
 */
class Secret extends TObject
{

    /**
     * Chave secreta que será utilizada para a criptografia
     * @var string
     */
    protected static $_key = 'secret_passwd';

    /**
     * Vetor de 16bits de inicialização da criptografia
     * @var string
     */
    private static $_iv = 'fFUXRWLpySSxtWW4';

    /**
     * Método padrão de criptografia utilizado pela Classe Secret
     * @var string
     */
    protected static $_method = 'aes256';

    /**
     * Instancia um objeto para criptografia de dados
     * @param string $key a chave utilizada para criptografar e descriptografar 
     * o conteúdo
     */
    public function __construct($key = NULL)
    {
        if (!is_null($key)) {
            $this->setKey($key);
        }
    }

    /**
     * Define a chave que será utilizada para a criptografia
     * @param string $key
     */
    public function setKey($key)
    {
        static::key($key);
    }

    /**
     * Retorna a chave utilizada para a criptografia
     * @return string
     */
    public function getKey()
    {
        return static::key();
    }

    /**
     * Define ou obtém a chave para criptografia 
     * @param string $key
     * @return string|NULL
     */
    public static function key($key = NULL)
    {
        if (is_null($key)) {
            return static::$_key;
        } else {
            static::$_key = $key;
        }
        return NULL;
    }

    /**
     * Retorna o tipo de criptografia utilizado
     * @return string
     */
    protected function getMethod()
    {
        return static::$_method;
    }

    /**
     * Define uma string de 16bits como vetor de inicialização da criptografia
     * @param string $iv string de 16bits, podendo ser utilizado 16 caracteres que não 
     * sejam caracteres especiais
     */
    public function setInitVector($iv)
    {
        static::initVector($iv);
    }

    /**
     * Define ou obtém o vetor de inicialização da criptografia
     * @param string $iv string de 16bits para inicialização, caso seja passada
     * retorna a string que está sendo utilizada
     * @return string
     */
    public static function initVector($iv = null)
    {
        if (!is_null($iv)) {
            $s = substr($iv, 0, 16);
            static::$_iv = $s;
        } else {
            return static::$_iv;
        }
    }

    /**
     * Faz uma criptografia dupla e retorna o conteúdo
     * @param string $data A string que deve ser duplamente criptografada
     * @return string O conteúdo duplamento criptografado 
     */
    public function doubleEncrypt($data)
    {
        return $this->base64Encode($this->iCrypt($this->iCrypt($data)));
    }

    /**
     * Descriptografa uma string com criptografia dupla
     * @param string $data
     * @return string
     */
    public function doubleDecrypt($data)
    {
        return $this->iDecrypt($this->iDecrypt($this->base64Decode($data)));
    }

    /**
     * Descriptografa a string e retorna seu conteúdo
     * @param string $data
     * @return string|null Retorna a string descriptografada, ou null se a chave 
     * e o vetor de inicialização não foram os mesmos utilizados para a criptografia
     */
    protected function iDecrypt($data)
    {
        return openssl_decrypt($data, $this->getMethod(), $this->getKey(), OPENSSL_RAW_DATA, $this->getInitVector());
    }

    /**
     * Descriptografa o conteúdo e retorna um string
     * Caso o conteúdo não esteja criptografado com a mesma chave e mesmo vetor
     * de inicialização retorna NULL
     * @param string $data
     * @return string|FALSE O conteúdo descriptografado ou falso caso a chave de 
     * criptografia, ou o vetor de inicialização, ou o string não combinam entre
     * si
     */
    public function decrypt($data)
    {
        return $this->iDecrypt($this->base64Decode($data));
    }

    /**
     * Uma string de 16 bits para ser utilizada como vector inicialização para 
     * a criptografia
     * @return string string de 16 bits
     */
    protected function getInitVector()
    {
        return static::$_iv;
    }

    /**
     * Criptografa o conteúdo passada e retorna criptografado
     * @param string $data A string a ser criptografada
     * @return string O conteúdo criptografado
     */
    public function encrypt($data)
    {
        return $this->base64Encode($this->iCrypt($data));
    }

    /**
     * Criptografa a string passada utilizando a chave de criptografia definida
     * e o vetor de inicialização
     * @param string $data A string a ser criptografada
     * @return string O conteúdo criptografado
     */
    protected function iCrypt($data)
    {
        $string = (string) $data;
        return openssl_encrypt($string, $this->getMethod(), $this->getKey(), OPENSSL_RAW_DATA, $this->getInitVector());
    }

    /**
     * Codifica a string passada para base64
     * @param string $data A string a ser passada para base64
     * @return string A string em base64
     */
    protected function base64Encode($data)
    {
        return base64_encode($data);
    }

    /**
     * Decodifica a string em base64
     * @param string $data A string a ser decodificada de base64
     * @return string A string decodificada
     */
    protected function base64Decode($data)
    {
        return base64_decode($data);
    }

}
