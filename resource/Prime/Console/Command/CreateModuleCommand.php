<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Console\Command;

use Prime\Console\BaseCommand;
use Prime\Core\TString;
use Prime\FileSystem\File;
use Prime\FileSystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

/**
 * Classe CreateModuleCommand <br>
 * 
 * @name CreateModuleCommand
 * @package Prime\Console\Command
 * @author tom
 * @createAt 01/08/2015
 */
class CreateModuleCommand extends BaseCommand {

    /**
     * Diretório raiz da aplicação
     * @var string
     */
    private $appRoot = NULL;

    /**
     * Nome do módulo que será criado
     * @var string
     */
    private $moduleName = NULL;

    /**
     * O caminho (path) onde o módulo foi criado
     * @var string
     */
    private $modulePath = NULL;

    public function __construct($name = 'create:module') {
        parent::__construct($name);
        $this->appRoot = dirname($_SERVER['SCRIPT_FILENAME']) . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR;
    }

    protected function configure() {
        $this->setProcessTitle('Module Create')
                ->setDescription('Cria um módulo dentro da aplicação')
                ->addArgument(
                        'name', InputArgument::REQUIRED, 'O nome do módulo a ser criado na aplicação')
                ->addOption('simple', 's', InputOption::VALUE_NONE, 'Define se o módulo vai ser criado simples, contendo apenas o diretório para os controllers')
                ->setHelp('console create:module {ModuleName} cria a estrutura de diretórios para um novo módulo na aplicação');
    }

    /**
     * Define o nome do módulo baseado no padrão tendo a primeira letra como 
     * maiúscula
     * @param string $name
     * @return string
     */
    private function createModuleName($name) {
        return ucfirst($name);
    }

    private function createConfigRouter() {
        $name = 'config.php';
        $filename = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $name;
        $module = $this->moduleName;
        if (file_exists($filename)) {
            $string = new TString(file_get_contents($filename));
        } else {
            throw new FileNotFoundException("$filename nao encontrado");
        }

        $fileConfig = $this->modulePath . $name;

        Filesystem::getInstance()->touch($fileConfig);
        Filesystem::getInstance()->chmod($fileConfig, 0660);

        $file = new File($fileConfig);
        $fileObject = $file->openFile('w');
        $fileObject->fwrite($string->getValue());
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->moduleName = $this->createModuleName($input->getArgument('name'));

        $this->modulePath = $this->appRoot . 'Modules' . DIRECTORY_SEPARATOR . $this->moduleName . DIRECTORY_SEPARATOR;

        $fs = Filesystem::getInstance();
        if (!$input->getOption('simple')) {
            $output->writeln('Vamos criar o módulo ' . $this->modulePath . ' completo');
            $fs->mkdir([
                $this->modulePath . 'Business',
                $this->modulePath . 'Controller',
                $this->modulePath . 'Model',
                $this->modulePath . 'View'
            ]);
        } else {
            $output->writeln('Vamos criar o módulo ' . $this->modulePath . ' simples');
            $fs->mkdir([
                $this->modulePath . 'Controller'
            ]);
        }
        $this->createConfigRouter();
        $fs->chmod($this->modulePath, 0770, 0000, TRUE);
        $output->writeln('<info>Módulo ' . $this->moduleName . ' criado com sucesso</info>');
    }

}
