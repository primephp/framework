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

namespace Prime\Console\Command;

use Prime\Console\BaseCommand;
use Prime\Core\TString;
use Prime\FileSystem\File;
use Prime\FileSystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Descrição de CreateControllerCommand
 *
 * @author Elton Luiz
 */
class CreatePageControllerCommand extends BaseCommand
{

    /**
     * Path do diretório de Módulos
     * @var string
     */
    private $modulesPath = NULL;

    public function __construct($name = 'create:pagecontroller')
    {
        parent::__construct($name);
        $this->modulesPath = dirname($_SERVER['SCRIPT_FILENAME']) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Modules';
        $this->modulesPath = realpath($this->modulesPath) . DIRECTORY_SEPARATOR;
    }

    /**
     * Configura o Command
     */
    protected function configure()
    {
        $this->setProcessTitle('PageController Create')
                ->setDescription('Cria um PageController dentro de um módulo específico, de acordo com os parâmetros passados')
                ->addArgument(
                        'module', InputArgument::REQUIRED, 'O nome do módulo aonde deve ser criado o PageController')
                ->addArgument(
                        'controller', InputArgument::OPTIONAL, 'O nome do PageController a ser criado, caso seja omitido, será criado um PageController com o mesmo nome do módulo')
                ->setHelp('console create:pagecontroller {ModuleName} {PageControllerName} cria o esqueleto de uma classe PageController');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $module = ucfirst($input->getArgument('module'));
        $controller = $input->getArgument('controller');

        if (!empty($controller)) {
            $controller = ucfirst($controller);
        } else {
            $controller = $module;
        }
        $controller .= 'PageController';

        $filename = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR;
        $filename .= 'page_controller.php.twig';
        if (file_exists($filename)) {
            $string = new TString(file_get_contents($filename));
            $string->replace('{{ controller }}', $controller)
                    ->replace('{{ module }}', $module)
                    ->replace('{{ date }}', date('d/m/Y'));
        } else {
            throw new FileNotFoundException("$filename nao encontrado");
        }

        $fileController = $this->modulesPath . $module . DIRECTORY_SEPARATOR . 'Controller' . DIRECTORY_SEPARATOR . $controller . '.php';

        if (file_exists($this->modulesPath . $module)) {
            Filesystem::getInstance()->touch($fileController);
            Filesystem::getInstance()->chmod($fileController, 0660);


            $file = new File($fileController);
            $fileObject = $file->openFile('w');
            $fileObject->fwrite($string->getValue());
            $output->writeln("<info>OK: $fileController criado com sucesso</info>");
        } else {
            $output->writeln("<error>FALHA: O módulo $module não existe ou não é gravável</error>");
        }
    }

}
