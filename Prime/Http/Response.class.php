<?php

namespace Prime\Http;

use Prime\Business\ISingleton,
    Prime\Business\IStaticCreate;

/**
 * @name Response
 * @package Prime\Http
 * @author tom
 *        
 */
class Response implements IStaticCreate, ISingleton {

    /**
     * 
     * @var str
     */
    protected $content = array();
    private static $_instance = NULL;

    /**
     * Cria um objeto do tipo response
     * caso passado conteúdo no construtor armazena o conteúdo para um futura
     * bufferização na tela do usuário
     * @param str $content
     */
    private function __construct() {
        
    }

    /**
     * Retorna uma instância única do objeto Response
     * @return Response
     */
    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new Response(NULL);
        }
        return self::$_instance;
    }

    /**
     * Cria um objeto do tipo response
     * caso passado conteúdo no construtor armazena o conteúdo para um futura
     * bufferização na tela do usuário
     * @param mixed $content
     * @param mixed $key 
     * @return Response Objeto do tipo Response
     */
    public static function buildResponse($content = NULL, $key = NULL) {
        $response = self::getInstance();
        $response->add($content, $key);
        return $response;
    }

    /**
     * Cria um objeto do tipo response
     * caso passado conteúdo no construtor armazena o conteúdo para um futura
     * bufferização na tela do usuário
     * @param mixed $content
     * @param mixed $key
     * @return Response Objeto do tipo Response
     */
    public static function create($content = NULL, $key = NULL) {
        return self::buildResponse($content, $key);
    }

    /**
     * armazena o conteúdo para um futura
     * bufferização na tela do usuário, podendo ser passado 
     * uma chave como index para o valor adicionado
     * @param str $value
     * @param string $key
     */
    public function add($value, $key = NULL) {
        if (!is_null($value)) {
            $this->content[$key] = $value;
        }
    }

    /**
     * Retorna o conteúdo do objeto Response
     * @return Ambigous <string, unknown>
     */
    public function getResponse() {
        $return = '';
        foreach ($this->content as $content) {
            $return .= $content;
        }
        return $return;
    }

    /**
     * Remove todo o conteúdo do objeto Response
     */
    public function clean() {
        $this->content = array();
    }

    /**
     * Bufferiza na tela todo o conteúdo do objeto
     * @param str $content
     * @return mixed
     */
    public function write($content = NULL) {
        $this->add($content);
        Response::printOut($this->getResponse());
    }

    /**
     * Imprime na tela o conteúdo no formato JSON
     */
    public function writeJson() {
        Response::printOut(json_encode($this->content));
    }

    /**
     * @todo
     */
    public function writeXML() {
        
    }

    /**
     * Imprime na tela o conteúdo passado sem nenhum tipo de 
     * tratamento prévio
     * @param str $content
     */
    public static function printOut($content) {
        echo (string) $content;
    }

}
