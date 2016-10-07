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

namespace Prime\Console\Command;

use Prime\Console\BaseCommand;
use Prime\FileSystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Classe CreateApplicationCommand <br>
 * 
 * @name CreateApplicationCommand
 * @package Prime\Console\Command
 * @author TomSailor
 * @createAt 30/07/2015
 */
class CreateApplicationCommand extends BaseCommand {

    private $dirBase;

    protected function configure() {
        $this->setName('create:app')
                ->setProcessTitle('Criar Skeleton da Aplicação')
                ->setDescription('Cria a estrutura de diretórios para a aplicação')
                ->addArgument(
                        'directory', InputArgument::OPTIONAL, 'O diretório onde será criada a aplicação')
                ->setHelp('console create:app {diretório} para criar o skeleton da aplicação');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $dir = $input->getArgument('directory');
        if ($dir) {
            $this->dirBase = $dir;
        } else {
            $this->dirBase = dirname($_SERVER['SCRIPT_FILENAME']);
        }
        $this->createSkeleton();
        $output->writeln("<info>Eskeleton da Aplicação criado com sucesso</info>");
    }

    /**
     * Cria a estrutura de diretórios utilizados na aplicação
     */
    private function createSkeleton() {
        $fileSystem = Filesystem::getInstance();

        $fileSystem->mkdir([
            'src/App/Modules',
            'src/App/Console',
            'src/App/DataSource',
            'src/App/Templates',
            'public/assets/css',
            'public/assets/js',
            'public/storage',
            'src/App/Templates',
            'data/log',
            'data/cache',
            'data/doc'
                ], 2770);
        $fileSystem->mirror(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'config', $this->dirBase . DIRECTORY_SEPARATOR . 'config');
    }

}
