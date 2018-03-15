<?php

namespace Prime\View;

use \Prime\Core\TObject;

/**
 * Description of View
 * @package Prime\View
 *
 * @author Elton Luiz
 */
abstract class AbstractView extends TObject implements ViewInterface
{

    use \Prime\Io\PrintableTrait;

    /**
     * Armazena os conteúdos adicionados dentro de um array
     * @var array 
     */
    protected $content = [];

    /**
     * Adiciona conteúdo no objeto
     * @param mixed $content
     */
    public function addContent($content)
    {
        $this->content[] = $content;
    }

    /**
     * Retorna uma string mixed com todos o conteúdo adicionado no objeto
     * @return str
     */
    protected function getContents()
    {
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
     * Retorna uma string representando o conteúdo da View
     * @return string
     */
    public function toString()
    {
        return $this->getOutput();
    }

    /**
     * Retorna na forma de uma string ao invés de escrever na saida de dados
     * pro navegador
     * @return string O conteúdo do objeto
     */
    public function getOutput()
    {
        return $this->getContents();
    }

}
