<?php

namespace Prime\Html\Page;

use App\Config\Config,
    Prime\Html\Base\HTMLBody,
    Prime\Html\Base\HTMLDiv,
    Prime\Html\Base\HTMLElement,
    Prime\Html\Base\HTMLHead,
    Prime\Html\Base\HTMLMeta,
    Prime\Html\Base\HTMLTitle,
    Prime\Html\Style\HTMLStyleLink;

/**
 * Descrição da Classe HTMLPage
 *
 * @author TomSailor
 */
class HTMLPage extends HTMLElement {

    /**
     * Variável que armazena o conteúdo da tag HEAD
     * @var HTMLHead
     */
    protected $head;

    /**
     * Variável que armazena o conteúdo da tag BODY
     * @var HTMLBody
     */
    protected $body;

    /**
     * Variável que armazena o conteúdo da tag TITLE
     * @var HTMLTitle
     */
    protected $title;

    /**
     * Método Construtor
     * Constrói uma Página HTML
     * @param <type> $tilePage
     */
    public function __construct($titlePage = NULL) {
        parent::__construct('html');
        $this->head = new HTMLHead();
        $this->body = new HTMLBody();
        $this->title = new HTMLTitle($titlePage);
    }

    /**
     * Método appendChild
     * Adiciona elementod dentro do BODY
     * da página HTML
     * @param HTMLElemnt $child
     */
    public function appendChild($child) {
        $this->body->appendChild($child);
    }

    /**
     * Método addHeadContent
     * Adiciona conteúdo na tag HEAD da página
     * @param HTMLElement $content
     */
    public function addHeadContent($content) {
        $this->head->appendChild($content);
    }

    /**
     * Método getOutput
     * Retorna o HTML na forma de uma string ao invés de escrever na saida de dados
     * pro navegador
     */
    public function getOutput() {
        $this->head->appendChild($this->title);
        parent::appendChild($this->head);
        parent::appendChild($this->body);
        header('Content-Type: text/html; charset=utf-8');
        return parent::getOutput();
    }

    /**
     * Método para criação de DIV
     * @param String $nameId
     * @return HTMLDiv 
     */
    public function addDiv($nameId = null) {
        $div = new HTMLDiv($nameId);
        return $div;
    }

    /**
     * Método addStyleLink
     * Adiciona um link de arquivo CSS na página
     * @param type $link 
     */
    public function addStyleLink($href) {
        $link = new HTMLStyleLink(Config::baseCSS() . $href);
        $this->head->appendChild($link);
    }

    /**
     * Adiciona um link para arquivos JavaScripts
     * @param type $src 
     */
    public function addScriptLink($src) {
        $link = new HTMLScript(Config::baseScripts() . $src);
        $this->head->appendChild($link);
    }

    /**
     * Define o charset da página HTML
     * @param type $content
     * @return HTMLMeta 
     */
    function setCharset($content) {
        $meta = new HTMLMeta();
        $meta->setMetaAttibute("http_equiv", "Content-Type");
        $meta->setContent("text/html; charset=$content");
        $this->head->appendChild($meta);
        return $meta;
    }

    /**
     * Define o dono da página
     * @param type $content
     * @return HTMLMeta 
     */
    function setOwner($content) {
        $meta = new HTMLMeta("OWNER");
        $meta->setContent($content);
        $this->head->appendChild($meta);
        return $meta;
    }

    function setSubject($content) {
        $meta = new HTMLMeta("SUBJECT");
        $meta->setContent($content);
        $this->head->appendChild($meta);
        return $meta;
    }

    function setRating($content = "GENERAL") {
        $meta = new HTMLMeta("RATING");
        $meta->setContent($content);
        $this->head->appendChild($meta);
        return $meta;
    }

    function setDescription($content) {
        $meta = new HTMLMeta("DESCRIPTION");
        $meta->setContent($content);
        $this->head->appendChild($meta);
        return $meta;
    }

    function setAbstract($content) {
        $meta = new HTMLMeta("ABSTRACT");
        $meta->setContent($content);
        $this->head->appendChild($meta);
        return $meta;
    }

    function setKeywords($content) {
        $meta = new HTMLMeta("KEYWORDS");
        $meta->setContent($content);
        $this->head->appendChild($meta);
        return $meta;
    }

    function setRevisitAfter($content) {
        $meta = new HTMLMeta("REVISIT-AFTER");
        $meta->setContent($content);
        $this->head->appendChild($meta);
        return $meta;
    }

    function setLanguage($content) {
        $meta = new HTMLMeta("LANGUAGE");
        $meta->setContent($content);
        $this->head->appendChild($meta);
        return $meta;
    }

    function setRobots($content = "All") {
        $meta = new HTMLMeta("ROBOTS");
        $meta->setContent($content);
        $this->head->appendChild($meta);
        return $meta;
    }

    function setPragma($content = "NO-CACHE") {
        $meta = new HTMLMeta();
        $meta->setMetaAttibute("http_equiv", "PRAGMA");
        $meta->setContent($content);
        $this->head->appendChild($meta);
        return $meta;
    }

    public function setTitle($title) {
        if (is_string($title)) {
            $this->title = $title;
        }
    }

}


