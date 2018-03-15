<?php

/*
 * The MIT License
 *
 * Copyright 2015 Elton Luiz.
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

use FilesystemIterator;
use Prime\Database\Connection;
use Prime\FileSystem\Filesystem;
use Prime\Server\Routing\RouteCollection;
use Prime\View\Template;
use Prime\View\TwigExtension;
use Symfony\Component\Debug\Debug;
use const DS;
use function mb_http_output;
use function mb_internal_encoding;

/**
 * Descrição da Classe Application
 *
 * @author Elton Luiz
 * @name Application
 * @package Prime\Server\Http
 * @createAt 06/08/2015
 */
class Application
{

    /**
     * Armazena a instância única de instância do objeto Application
     * @var Application
     */
    protected static $instance = NULL;

    /**
     * Coleção de rotas da aplicação
     * @var RouteCollection
     */
    protected static $routes;

    /**
     * Armazena a instância única de 
     * @var Kernel
     */
    private $kernel = null;

    /**
     * Instancia a aplicação
     * @param RouteCollection $routes Coleção de rotas para o mapeamento da aplicação
     * @param array $config Array de configurações da aplicação
     */
    private function __construct($routes = NULL)
    {
        if (is_null(static::$instance)) {
            static::$routes = new RouteCollection();
            $this->kernel = Kernel::getInstance(static::$routes);
        }
    }

    /**
     * Retorna a instância do Kernel do Framework
     * @return Kernel
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * Implementação na aplicação para registrar os Listeners utilizados na aplicação
     * através do arquivo de configuração de Listeners
     */
    private function registerListeners()
    {
        $listeners = require Filesystem::getInstance()->getPath('root') . '/config/listeners.php';
        $dispatcher = $this->getKernel()->getDispatcher();
        foreach ($listeners as $listener) {
            $dispatcher->addSubscriber($listener);
        }
    }

    /**
     * Recupera o arquivo de configuração dos módulos e adiciona as suas respectivas 
     * rotas
     */
    private function getModulesConfig()
    {
        $dirModules = Filesystem::getInstance()->getPath('modules');
        $file = new FilesystemIterator($dirModules);
        foreach ($file as $fileinfo) {
            if ($fileinfo->isDir()) {
                $fileConfig = $this->getConfigFile($dirModules . DS . $fileinfo->getFilename());
                if ($fileConfig instanceof RouteCollection) {
                    static::$routes->addCollection($fileConfig);
                }
            }
        }
    }

    /**
     * Retorna a configuração de rotas do Módulo
     * @param string $module
     * @return RouteCollection
     */
    private function getConfigFile($module)
    {
        $file = $module . DS . 'config.php';
        if (file_exists($file)) {
            return require $file;
        }
    }

    /**
     * Returns a single instance of the application Kernel
     * @return Application
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * Inicializa a aplicação
     * @param boolean $debug Caso TRUE define o debug da aplicação
     * @return Application
     */
    public function init($debug = FALSE)
    {
        $this->getModulesConfig();
        $this->debug($debug);
        $this->database();
        $this->template();
        $this->registerListeners();
        return $this;
    }

    /**
     * Configura o debug da aplicação
     * @param boolean $debug
     */
    private function debug($debug)
    {
        if ($debug === TRUE) {
            $debug = Debug::enable();
        } else {
            set_error_handler('primeErrorHandler');
            set_exception_handler('primeExceptionHandler');
            ini_set("display_errors", "off");
            error_reporting(E_ALL);
        }
    }

    /**
     * Finaliza a Aplicação chamando Kernel->handle() para manipular a
     * requisição
     * @return Application
     */
    public function finalyze()
    {
        $this->kernel->handle();
        return $this;
    }

    /**
     * Carrega a configuração do banco de dados
     */
    protected function database()
    {
        $array = require Filesystem::getInstance()->getPath('root') . '/config/database.php';
        Connection::config($array);
    }

    /**
     * Carrega as configurações e faz a configuração inicial do uso do Twig
     * para a manipulação dos templates na aplicação
     */
    protected function template()
    {
        $config = require Filesystem::getInstance()->getPath('root') . '/config/view.php';
        $twig = Template::setEnviroment($config);
        $twig->addExtension(new TwigExtension());
        $filesystem = Filesystem::getInstance();
        Template::addPath($filesystem->getPath('templates'));
        mb_internal_encoding($twig->getCharset());
        mb_http_output($twig->getCharset());
    }

}
