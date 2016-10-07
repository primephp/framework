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
use Prime\FileSystem\File;
use Prime\FileSystem\Filesystem;
use Prime\Model\DataSource\Connection;
use Prime\Model\DataSource\Metadata\CreateDataSource;
use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Descrição da Classe CreateDataSourceCommand
 *
 * @name CreateDataSourceCommand
 * @package Prime\Console
 * @createAt 22/07/2015
 * @author Elton Luiz
 */
class CreateDataSourceCommand extends BaseCommand {

    private function isConnected() {
        if (!Connection::get()) {
            throw new RuntimeException('Há conexão com com banco de dados.');
        }
    }

    protected function configure() {
        $this->setName('create:datasource')
                ->setProcessTitle('DataSource Create')
                ->setDescription('Cria um objeto para acesso aos dados de uma tabela do banco de dados da aplicação')
                ->addArgument(
                        'entity', InputArgument::REQUIRED, 'O nome da tabela para qual deve ser criado o DataSource')
                ->setHelp('console create:DataSource {NomeDaTabela} para criar uma classe de acesso ao banco de dados');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->isConnected();
        $entity = $input->getArgument('entity');

        $dataSource = new CreateDataSource($entity);

        $dirBase = dirname($_SERVER['SCRIPT_FILENAME']) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'DataSource';
        $filename = realpath($dirBase) . DIRECTORY_SEPARATOR . $dataSource->getClassName() . '.php';

        Filesystem::getInstance()->touch($filename);
        Filesystem::getInstance()->chmod($filename, 0660);

        $file = new File($filename);
        $fileObject = $file->openFile('w');
        $fileObject->fwrite($dataSource->getOutput());


        $output->writeln("<info>$filename criado com sucesso!!!</info>");
        $output->writeln('<comment>Cria sua classe de modelo de dados e estenda de ' . $dataSource->getClassName() . '</comment>');
    }

}
