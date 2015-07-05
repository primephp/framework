<?php

namespace Prime\Html\Base;

use Prime\Html\Input\HTMLInput,
    Prime\Html\Input\HTMLInputFile, 
    Prime\Server\Http\Url;

/**
 * @author Gedalias Freitas da Costa
 * @copyright GPL - 2008
 *
 *
 * Concluida
 * 
 */
class HTMLForm extends HTMLElement {

    public function __construct($name) {
        parent::__construct("form");
        $this->name = "$name";
        $this->id = "$name";
        $this->enctype = "application/x-www-form-urlencoded";
    }

    /**
     * Configura o atributo action do formulário (que representa aquele que vai analizar o
     * o conteúdo do formulário)
     * Por padrão configura a própria página onde reside o formulário.
     *
     * @param string $action
     */
    public function setAction($action) {
        if (is_string($action)) {
            $this->action = $action;
        } else {
            if ($action instanceof Url) {
                $this->action = $action->queryString();
            }
        }
    }

    public function setMethod($method) {
        if (is_string($method)) {
            $this->method = $method;
        } else {
            $class = __CLASS__;
            $method = __METHOD__;
            trigger_error("Atributo incorreto. Deve ser uma string em {$class}::{$method}.", E_USER_ERROR);
        }
    }

    /**
     * Adiciona cada HTMLInput instanciado ao Formulario HTML
     *
     * @param HTMLInput $element
     */
    public function addElement(HTMLInput $element) {
        if ($element instanceof HTMLInput) {
            if ($element instanceof HTMLInputFile) {
                $this->enctype = "multipart/form-data";
            }
            parent::appendChild($element);
        } else {
            trigger_error("O parâmetro passado não é um HTMLInput.", E_USER_ERROR);
        }
    }

    /**
     * Adiciona cada HTMLInput instanciado ao Formulario HTML
     *
     * @param HTMLInput $element
     */
    public function appendChild($element) {
        if ($element instanceof HTMLInputFile) {
            $this->enctype = "multipart/form-data";
        }
        parent::appendChild($element);
    }

    /**
     * Adiciona um evento e suas respectivas lista de métodos
     * javascript
     *
     * @param string $eventName
     * @param string $functions
     */
    public function addEvents($event, $funcList) {
        if (is_string($event) && is_string($funcList)) {
            //acrescenta uma quantidade ilimitada de metodos javascript
            $this->$event = "$funcList";
        }
    }

}


