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

use Symfony\Component\Console\Application as ConsoleApplication;

/**
 * Descrição da Classe Application
 *
 * @name Application
 * @package Prime\Console
 * @createAt 22/07/2015
 * @author Elton Luiz
 */
class Application extends ConsoleApplication {

    public function __construct($name = 'PrimePHP Application', $version = '0.1alpha') {
        parent::__construct($name, $version);
        $this->setPrimeCommands();
    }

    public function setPrimeCommands() {
        $this->add(new Command\CreateDataSourceCommand());
        $this->add(new Command\CreateApplicationCommand());
        $this->add(new Command\CreateModuleCommand());
    }

}
