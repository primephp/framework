<?php

namespace Prime\View;

use App\Config\AppConfig;

/**
 * Descrição da Classe Template
 * Esta classe é responsável por tratar Templates
 * @name Template
 * @package Prime\View
 * @version 1.0.1
 * @author TomSailor
 * @since 09/10/2011
 * @access public
 */
class Template implements ViewInterface {

    private $content;
    private $changeList = array();
    private $encoding = 'utf-8';
    private $tag_begin = '{$';
    private $tag_end = "}";
    private $filepath;
    private $extra;

    public function __construct($filepath = NULL) {
        $this->changeList = array();
        $this->extra = array();
        $this->content = NULL;
        if (!is_null($filepath)) {
            $this->load($filepath);
        }
    }

    public function load($filepath) {
        $fold = AppConfig::baseTemplate();
        $content = $fold . $filepath;
        $this->filepath = $content;
        if (file_exists($content)) {
            $this->content = file_get_contents($content);
        } else if (is_string($filepath)) {
            $this->content = $filepath;
        } else {
            trigger_error("Arquivo $content não existe.", E_USER_ERROR);
        }
    }

    /**
     * Método assign
     * Define as variáveis a serem substituídas no template
     * @param type $var nome da variável
     * @param type $value valor a ser atribuído à variável
     */
    public function assign($var, $value) {
        $this->changeList[$var] = $value;
    }

    /**
     * Retorna o conteúdo do template
     * @param str $filepath Caminho do Arquivo de Template
     * @return str o conteúdo do template com todos os conteúdos das marcações
     * já substituídos
     */
    public function fetch($filepath = NULL) {

        if (!is_null($filepath)) {
            $this->load($filepath);
        }
        return $this->getOutput();
    }

    /**
     * Imprime o conteúdo do template
     * @param str $filepath Caminho do Arquivo de Template
     * @return str o conteúdo do template com todos os conteúdos das marcações
     * já substituídos 
     */
    public function display($filepath = NULL) {
        if (!is_null($filepath)) {
            $this->load($filepath);
        }

        echo $this->getOutput();
    }

    /**
     * Retorna o conteúdo do template sem imprimir na tela
     * @return string $content
     */
    public function getOutput() {
        foreach ($this->changeList as $change => $object) {
            $replace = "";
            if (is_object($object)) {
                $replace = $object->getOutput();
            } else if (is_string($object)) {
                $replace = $object;
            } else if (is_array($object)) {
                $replace = implode($object);
            }
            $change = $this->tag_begin . $change . $this->tag_end;
            $this->content = str_replace("$change", "$replace", $this->content);
        }
        if ($this->getContent()) {
            $this->content .= $this->getContent();
        }
        return $this->content;
    }

    /**
     * Imprime na tela o conteúdo do Template
     */
    public function printOut() {
        /*
          //incia o buffer de saída
          ob_start();

          echo $this->getOutput();

          //retorna o conteúdo do buffer de saída
          $contents = ob_get_contents();

          //limpa o buffer de saída
          ob_end_clean();

          //Prepara o objeto DOM
          $dom = new DOMDocument("HTML", "utf-8");

          $dom->formatOutput = TRUE;
          $dom->preserveWhiteSpace = FALSE;

          //carrega o HTML
          $dom->loadHTML($contents);

          // Despeja um documento interno em uma string usando a formatação HTML
          $output = $dom->saveHTML();
         */
        echo $this->getOutput();
        //echo $output;
    }

    public function encoding($encoding) {
        $this->encoding = $encoding;
    }

    /**
     * Define as tags de abertura e defechamento das marcas de substituição
     * @param str $begin_tag
     * @param str $end_tag 
     */
    public function defineTags($begin_tag, $end_tag) {
        $this->tag_begin = $begin_tag;
        $this->tag_end = $end_tag;
    }

    /**
     * Cria e retorna um novo objeto Template
     * @param type $filepath
     * @return Template 
     */
    public function newTemplate($filepath) {
        $template = new Template($filepath);
        return $template;
    }

    /**
     * Retorna a URL do template que está sendo utilizado
     * @return type 
     */
    public function getUrlTemplate() {
        return $this->filepath;
    }

    /**
     * Adiciona conteúdo no final do template, aceitando objeto do Tipo HTMLElement
     * @param mixed $content 
     */
    public function addContent($content) {
        if (is_object($content)) {
            $this->extra[] = $content->getOutput();
        } else {
            $this->extra[] = $content;
        }
    }

    /**
     * Retorna o conteúdo extra adicionado no Template
     * @return str 
     */
    private function getContent() {
        $content = NULL;
        foreach ($this->extra as $extra) {
            $content .= $extra;
        }

        return $content;
    }

}
