<?php

namespace App;

use Prime\FileSystem\Filesystem;
use Prime\Server\Http\Application as PrimeApplication;

/**
 * Descrição da Classe Application
 *
 * @author TomSailor
 * @name Application
 * @package App
 * @createAt 06/08/2015
 */
class Application extends PrimeApplication {

    protected function registerListeners() {
        $listeners = require Filesystem::getInstance()->getPath('root') . '/config/listeners.php';
        $dispatcher = $this->getKernel()->getDispatcher();
        foreach ($listeners as $listener) {
            $dispatcher->addSubscriber($listener);
        }
    }
    
}
