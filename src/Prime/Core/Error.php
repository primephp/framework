<?php

namespace Prime\Core;

use ArrayObject,
    Prime\Html\Base\HTMLDiv,
    Prime\Html\Base\HTMLParagraph;

/**
 * Descrição da Classe Error
 * @package Prime\Core
 * @author tom
 * @since 26/06/2013
 */
class Error extends TObject
{

    /**
     *
     * @var ArrayObject 
     */
    private $obj;

    public function __construct()
    {
        $this->obj = new ArrayObject();
    }

    /**
     * Adiciona um texto definindo o tipo de erro
     * @param str $text
     */
    public function add($text)
    {
        if (is_string($text)) {
            $this->obj->append($text);
        }
    }

    /**
     * Retorna um array contendo todos os textos de definição de Erros
     * @return array
     */
    public function getErrors()
    {
        return $this->obj->getArrayCopy();
    }

    /**
     * Retorna o total de erros adicionados no objeto
     * @return int
     */
    public function count()
    {
        return $this->obj->count();
    }

    /**
     * Retorna <b>TRUE</b> caso haja algum erro adiconado no objeto
     * e <b>FALSE</b> caso não haja erro.
     * @return boolean
     */
    public function hasError()
    {
        return (bool) $this->obj->count();
    }

    /**
     * Retorna um DIV com as mensagem de erros formatadas dentro de tags Paragraph
     * @return type
     */
    public function htmlFormatted()
    {
        if ($this->count()) {
            $div = new HTMLDiv('div_errors');
            for ($index = 0; $index < $this->count(); $index++) {
                $p = new HTMLParagraph($this->obj->offsetGet($index));
                if ($index < $this->count() - 1) {
                    $p->appendText(';');
                } else {
                    $p->appendText('.');
                }
                $div->appendChild($p);
            }
            return $div->getOutput();
        } else {
            return 'Falha desconhecida no processamento da requisição';
        }
    }

}
