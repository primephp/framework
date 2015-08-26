<?php

namespace Prime\Security;

use Prime\Core\Object;

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
class Secret extends Object
{

    protected static $_key = 'secret_passwd';
    private static $_iv = 'fFUXRWLpySSxtWW4';
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
     * Uma string de 16 bits para ser utilizada como vector inicialização para 
     * a criptografia
     * @return string string de 16 bits
     */
    protected function getInitVector()
    {
        return static::$_iv;
    }

    /**
     * Criptografa o conteúdo passada e retorna cryptografado e em base64
     * @param string $data
     * @return string
     */
    public function encrypt($data)
    {
        $data = (string) $data;
        return base64_encode(openssl_encrypt($data, $this->getMethod(), $this->getKey(), OPENSSL_RAW_DATA, $this->getInitVector()));
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
        return openssl_decrypt(base64_decode($data), $this->getMethod(), $this->getKey(), OPENSSL_RAW_DATA, $this->getInitVector());
    }

}
