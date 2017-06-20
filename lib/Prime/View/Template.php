<?php

/*
 * The MIT License
 *
 * Copyright 2015 TomSailor.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Prime\View;

use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_TemplateInterface;

/**
 * Classe Template <br>
 * 
 * @name Template
 * @package Prime\View
 * @author TomSailor
 * @createAt 24/07/2015
 */
class Template extends View {

    /**
     *
     * @var Twig_Loader_Filesystem
     */
    protected static $loader = NULL;

    /**
     *
     * @var Twig_Environment
     */
    protected static $env = NULL;
    private $name;
    private $index;
    private $changeList = [];

    public function __construct($path = null, $index = null) {
        $this->setPath($path, $index);
        $this->addPath(__DIR__ . DIRECTORY_SEPARATOR . 'prime', 'prime');
    }

    /**
     * Define o caminho do template que deverá ser utilizado
     * @param string $path
     * @param int $index
     */
    public function setPath($path, $index = null) {
        if (!is_null($path)) {
            $this->name = $path;
        }
        if (!is_null($index)) {
            $this->index = $index;
        }
    }

    /**
     * Inicializa o Carregador de templates
     * @return \Twig_Loader_Filesystem
     */
    public static function initLoader() {
        if (is_null(self::$loader)) {
            self::$loader = new Twig_Loader_Filesystem(__DIR__);
        }
        return self::$loader;
    }

    /**
     * Inicializa o ambiente de templates
     * @param array $env
     * @return Twig_Environment
     */
    public static function initEnviroment(array $env = []) {
        if (is_null(self::$env)) {
            self::$env = new Twig_Environment(self::initLoader(), $env);
        }
        return self::$env;
    }

    /**
     * Adiciona um novo caminho de templates e define um namespace para o mesmo
     * @param string $path
     * @param string $namespace
     */
    public static function addPath($path, $namespace = Twig_Loader_Filesystem::MAIN_NAMESPACE) {
        $loader = self::initLoader();
        $loader->addPath($path, $namespace);
    }

    /**
     * Adiciona um novo caminho de templates e define um namespace para o mesmo 
     * no início 
     * @param string $path
     * @param string $namespace
     */
    public static function prependPath($path, $namespace = Twig_Loader_Filesystem::MAIN_NAMESPACE) {
        $loader = self::initLoader();
        $loader->prependPath($path, $namespace);
    }

    /**
     * Define o ambiemte de visões
     * @param array $env Recebe um array contendo as configurações do Twig
     * @return Twig_Environment Retorna a classe de ambiente
     */
    public static function setEnviroment(array $env) {
        return self::initEnviroment($env);
    }

    /**
     * Método assign
     * Define as variáveis a serem substituídas no template
     * @param string $var nome da variável
     * @param mixed $value valor a ser atribuído à variável
     */
    public function assign($var, $value) {
        $this->changeList[$var] = $value;
    }

    /**
     * Carrega o template baseado no nome passado
     * @return Twig_TemplateInterface
     */
    public function load($name = null, $index = null) {
        $this->setPath($name, $index);
        $env = self::initEnviroment();
        return $env->loadTemplate($this->name, $this->index);
    }

    /**
     * Adiciona conteúdo no template que será introduzido no local onde estiver
     * a variável {{ a_content }}
     * @param mixed $content
     */
    public function addContent($content) {
        parent::addContent($content);
    }

    /**
     * Retorna o conteúdo do template
     * @return string
     */
    public function getOutput() {
        $template = $this->load();
        $this->assign('a_content', $this->getContents());
        return $template->render($this->changeList);
    }

    /**
     * Imprime na tela o conteúdo do template
     */
    public function printOut() {
        echo $this->getOutput();
    }

}
