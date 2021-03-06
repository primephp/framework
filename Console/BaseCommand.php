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

namespace Prime\Console;

use LogicException;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Classe Command
 * @name Command
 * @package Prime\Console
 * @since 23/07/2015
 * @author Elton Luiz
 */
class BaseCommand extends SymfonyCommand
{

    /**
     * Define uma ajuda par ao comando
     * @param string $help
     * @return BaseCommand
     */
    public function setHelp($help)
    {
        parent::setHelp($help);
        return $this;
    }

    /**
     * Esse método é responsável pela execução do Command em si
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws LogicException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        throw new LogicException('Esse método deve ser substituído na classe command concreta.');
    }

}
