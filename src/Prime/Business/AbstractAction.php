<?php

namespace Prime\Business;

use Prime\Core\Error;

/**
 * Descrição da Classe AbstractAction
 * @name AbstractAction
 * @package Prime\Business
 * @author TomSailor
 */
abstract class AbstractAction implements ActionInterface
{

    private $errors = NULL;

    public function __construct()
    {
        $this->errors = new Error();
    }

    /**
     * Adiciona uma mensagem de erro ao Action
     * @param str $text
     */
    protected function addError($text)
    {
        $this->errors->add($text);
    }

    /**
     * Adiciona um array de errors
     * @param array $errors
     */
    public function addErrors(array $errors)
    {
        foreach ($errors as $value) {
            $this->addError($value);
        }
    }

    /**
     * Retorna o objeto do Tipo Error instanciado
     * @return Error
     */
    public function getObjectErrors()
    {
        return $this->errors;
    }

    /**
     * Retorna TRUE caso haja mensagem de erro no Action
     * ou FALSE caso não haja
     * @return boolean
     */
    public function hasErrors()
    {
        if ($this->errors->count()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
