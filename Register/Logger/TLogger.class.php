<?php

namespace Prime\Register\Logger;

/**
 * classe TLogger
 * @package Prime\Register\Logger
 * Esta classe provê uma interface abstrata para definição de algoritmos de LOG
 */

abstract class TLogger {

    protected $filename;  // local do arquivo de LOG

    /*
     * mÃ©todo __construct()
     * instancia um logger
     * @param $filename = local do arquivo de LOG
     */

    public function __construct($filename) {
        $this->filename = $filename;
        // reseta o conteúdo do arquivo
        //file_put_contents($filename, '');
    }

    // define o método write como obrigatório em todas as classes filhas
    abstract function write($message);
}
