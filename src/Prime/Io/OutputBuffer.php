<?php

namespace Prime\Io;

use Prime\Core\TObject;
use Prime\Pattern\Singleton\ISingleton;

/**
 * Descrição de OutputBuffer
 * Objeto responsável por ativar o buffer de saída. 
 * Enquanto o buffer de saída estiver ativo, não é enviada a saída do script 
 * (exceto cabeçalhos), ao invés da saída é armazenada em um buffer interno. 
 * @author Elton Luiz <contato@eltonluiz.com.br>
 */
class OutputBuffer extends TObject implements ISingleton {

    private static $_instance = NULL;

    /**
     *  Descrição de OutputBuffer
     * Objeto responsável por ativar o buffer de saída. 
     * Enquanto o buffer de saída estiver ativo, não é enviada a saída do script 
     * (exceto cabeçalhos), ao invés da saída é armazenada em um buffer interno. 
     * @param string $output_callback Uma função output_callback opcional pode 
     * ser especificado. Esta função recebe uma string como um parâmetro e deve 
     * retornar uma string. A função será chamada quando o buffer de saída é 
     * liberado (enviada) ou limpo (com ob_flush, função ob_clean ou similar)
     * ou quando o buffer de saída é liberado para o navegador no final do pedido.
     * @param string $chunk_size Se o chunk_size parâmetro opcional é passado, 
     * o buffer será liberado depois de qualquer chamada de saída que faz com 
     * que o comprimento do buffer para chunk_size igual ou superior. O valor 
     * padrão 0 significa que a função de saída só será chamado quando o buffer 
     * de saída está fechada.
     * @param string $flags 
      O parâmetro flags é uma máscara de bits que controla as operações que podem ser
     * realizadas no buffer de saída. O padrão é permitir que os buffers de 
     * saída a ser limpa, corada e removidos, o que pode ser definido 
     * explicitamente via 
     * PHP_OUTPUT_HANDLER_CLEANABLE | 
     * PHP_OUTPUT_HANDLER_FLUSHABLE | 
     * PHP_OUTPUT_HANDLER_REMOVABLE, ou 
     * PHP_OUTPUT_HANDLER_STDFLAGS como taquigrafia.
     * @return void
     */
    private function __construct($output_callback, $chunk_size, $flags) {
        return ob_start($output_callback, $chunk_size, $flags);
    }

    public static function getInstance($output_callback = NULL,
            $chunk_size = NULL, $flags = NULL) {
        if (is_null(self::$_instance)) {
            self::$_instance = new OutputBuffer($output_callback, $chunk_size, $flags);
        }
        return self::$_instance;
    }

    /**
     * Inicializa o buffer e retorna uma instância única do objeto OutputBuffer
     * @return OutputBuffer
     */
    public static function initialize($output_callback = NULL,
            $chunk_size = NULL, $flags = NULL) {
        return self::getInstance($output_callback, $chunk_size, $flags);
    }

    /**
     * Limpa e apaga o buffer de saída
     * @return void Nenhum valor é retornado.
     */
    public function clean() {
        ob_clean();
    }

    /**
     * Limpo (apagar) o buffer de saída e desligue o buffer de saída
      @return boolean <b> TRUE </ b> em caso de sucesso ou <b> FALSE </ b> em caso de falha
     */
    public function endClean() {
        return ob_end_clean();
    }

    /**
     * Descarrega (enviar) o buffer de saída e desligue o buffer de saída
     * @return boolean <b> TRUE </ b> em caso de sucesso ou <b> FALSE </ b> em caso de falha
     */
    public function endFlush() {
        return ob_end_flush();
    }

    /**
     * Descarrega (envia) o buffer de saída
     * @return void Nenhum valor é retornado.
     */
    public function flush() {
        return ob_flush();
    }

    /**
     * Obtém o conteúdo do buffer e exclui o buffer de saída atual
     * @return string Retorna o conteúdo do buffer de saída e saída final 
     * buffering. Se o buffer de saída não está ativo, então FALSE é retornado.
     */
    public function getClean() {
        return ob_get_clean();
    }

    /**
     * Obtém o conteúdo do buffer de saída sem limpá-lo
     * @return string O conteúdo armazenado no buffer de saída
     */
    public function getContents() {
        return ob_get_contents();
    }

    /**
     * Libera o buffer de saída, devolvê-lo como uma string e desativa o 
     * buffer de saída.
     * @return string O conteúdo armazenado no buffer de saída
     */
    public function getFlush() {
        return ob_get_flush();
    }

    /**
     * Retorna o tamanho do buffer de saída
     * @return mixed Retorna o comprimento de o conteúdo do buffer de saída, 
     * em bytes, ou FALSE se sem buffer está ativo. 
     */
    public function getLength() {
        return ob_get_length();
    }

    /**
     * Retorna o nível de aninhamento do mecanismo de buffer de saída.
     * @return int Retorna o nível de manipuladores de buffer de saída 
     * aninhados ou zero se o buffer de saída não está ativa. 
     */
    public function getLevel() {
        return ob_get_level();
    }

    /**
     * Obtém a situação dos buffers de saída
     * @param boolean $full_status TRUE para retornar todos os níveis de buffer
     * de saída ativos. Se FALSE ou não definido, apenas o buffer de saída de 
     * nível superior é retornado. 
     * @return type Se chamado sem o parâmetro full_status ou com 
     * full_status = FALSE uma matriz simples com os elementos retornado
     */
    public function getStatus($full_status) {
        return ob_get_status($full_status);
    }

    /**
     * Descarrega o conteúdo do buffer armazenado
     */
    public function dump() {
        return $this->endFlush();
    }

}
