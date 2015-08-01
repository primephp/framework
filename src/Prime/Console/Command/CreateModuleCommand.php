<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Console\Command;

use Prime\Console\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

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
    private $moduleName = NULL;

    public function __construct($name = 'create:module') {
        parent::__construct($name);
        $this->appRoot = dirname($_SERVER['SCRIPT_FILENAME']) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;
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

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->moduleName = $this->createModuleName($input->getArgument('name'));

        $baseDir = $this->appRoot . 'Modules' . DIRECTORY_SEPARATOR . $this->moduleName . DIRECTORY_SEPARATOR;

        $fs = \Prime\FileSystem\Filesystem::getInstance();
        if (!$input->getOption('simple')) {
            $output->writeln('Vamos criar o módulo ' . $baseDir . ' completo');
            $fs->mkdir(array(
                $baseDir . 'Business',
                $baseDir . 'Controller',
                $baseDir . 'Model',
                $baseDir . 'View'
                    ));
        } else {
            $output->writeln('Vamos criar o módulo ' . $baseDir . ' simples');
            $fs->mkdir(array(
                $baseDir . 'Controller'
                    ));
        }
        $output->writeln('Módulo ' . $this->moduleName . ' criado com sucesso');
    }

}
