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
use Prime\Model\DAO\Connection;
use Prime\Model\DAO\Metadata\CreateDAO;
use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Descrição da Classe CreateDaoCommand
 *
 * @name CreateDaoCommand
 * @package Prime\Console
 * @createAt 22/07/2015
 * @author Elton Luiz
 */
class CreateDaoCommand extends BaseCommand {

    private function isConnected() {
        if (!Connection::get()) {
            throw new RuntimeException('Há conexão com com banco de dados.');
        }
    }

    protected function configure() {
        $this->setName('create:dao')
                ->setProcessTitle('DAO Create')
                ->setDescription('Cria um objeto para acesso aos dados de uma tabela do banco de dados da aplicação')
                ->addArgument(
                        'entity', InputArgument::REQUIRED, 'O nome da tabela para qual deve ser criado o DAO')
                ->setHelp('console create:dao {NomeDaTabela} para criar uma classe de acesso ao banco de dados');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->isConnected();
        $entity = $input->getArgument('entity');

        $dao = new CreateDAO($entity);
        $output->write($dao->getOutput());
    }

}
