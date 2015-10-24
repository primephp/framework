<?php

/*
 * The MIT License
 *
 * Copyright 2015 quantum.
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

namespace Prime\Server\Http;

use Prime\FileSystem\Filesystem;
use Prime\Model\DataSource\Connection;
use Prime\Server\Routing\RouteCollection;
use Prime\View\Template;
use Symfony\Component\Debug\Debug;

/**
 * Descrição da Classe Application
 *
 * @author TomSailor
 * @name Application
 * @package Prime\Server\Http
 * @createAt 06/08/2015
 */
class Application {

    /**
     * Armazena a instância única de instância do objeto Application
     * @var Application
     */
    protected static $instance = NULL;

    /**
     * Armazena a instância única de 
     * @var Kernel
     */
    private $kernel = NULL;

    /**
     * Define se o DEBUG da aplicação está ou não habilitado
     * @var boolean
     */
    private $debug = FALSE;

    /**
     * Instancia a aplicação
     * @param RouteCollection $routes Coleção de rotas para o mapeamento da aplicação
     * @param array $config Array de configurações da aplicação
     */
    private function __construct($routes = NULL) {
        if (!is_null($routes)) {
            $this->kernel = Kernel::getInstance($routes);
        }
    }

    /**
     * Retorna a instância do Kernel do Framework
     * @return Kernel
     */
    public function getKernel() {
        return $this->kernel;
    }

    /**
     * Implementação na aplicação para registrar os Listeners utilizados na aplicação
     * através do arquivo de configuração de Listeners
     */
    protected function registerListeners() {
        
    }

    /**
     * Returns a single instance of the application Kernel
     * @param RouteCollection $routes Coleção de rotas para o mapeamento da aplicação
     * @param array $config Array de configurações da aplicação
     * @return Application
     */
    public static function getInstance($routes = NULL) {
        if (is_null(static::$instance)) {
            static::$instance = new static($routes);
        }
        return static::$instance;
    }

    /**
     * Inicializa a aplicação
     * @param boolean $debug Caso TRUE define o debug da aplicação
     */
    public function init($debug = FALSE) {
        $this->debug($debug);
        $this->database();
        $this->template();
        $this->registerListeners();
    }

    /**
     * Configura o debug da aplicação
     * @param boolean $debug
     */
    private function debug($debug) {
        if ($debug === TRUE) {
            $debug = Debug::enable();
        }
    }

    /**
     * Finaliza a Aplicação chamando Kernel->handle() para manipular a 
     * requisição
     */
    public function finalyze() {
        $this->kernel->handle();
    }

    /**
     * Carrega a configuração do banco de dados e abre uma conexão
     */
    protected function database() {
        $array = require Filesystem::getInstance()->getPath('root') . '/config/database.php';
        Connection::open($array);
    }

    /**
     * Carrega as configurações e faz a configuração inicial do uso do Twig
     * para a manipulação dos templates na aplicação
     */
    protected function template() {
        $config = require Filesystem::getInstance()->getPath('root') . '/config/view.php';
        Template::setEnviroment($config);
        $filesystem = Filesystem::getInstance();
        Template::addPath($filesystem->getPath('templates'));
    }

}
