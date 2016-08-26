<?php

namespace Prime\View;

/**
 * Description of View
 * @package Prime\View
 *
 * @author tom
 */
abstract class View implements ViewInterface {

    /**
     * Armazena os conteúdos adicionados dentro de um array
     * @var array 
     */
    protected $content = [];

    /**
     * Adiciona conteúdo no objeto
     * @param mixed $content
     */
    public function addContent($content) {
        $this->content[] = $content;
    }

    /**
     * Retorna uma string mixed com todos o conteúdo adicionado no objeto
     * @return str
     */
    protected function getContents() {
        $content = '';
        foreach ($this->content as $value) {
            if ($value instanceof ViewInterface) {
                $content .= $value->getOutput();
            } else {
                $content .= $value;
            }
        }
        return $content;
    }

    /**
     * Retorna na forma de uma string ao invés de escrever na saida de dados
     * pro navegador
     * @return str
     */
    public function getOutput() {
        return $this->getContents();
    }

    /**
     * Imprime na saída o conteúdo do objeto
     */
    public function printOut() {
        echo $this->getOutput();
    }

}
