<?php

use \App\Resource\AppConfig;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

return [
    /*
      |-------------------------------------------------------------------------
      | Configuração para DEBUG
      |-------------------------------------------------------------------------
      |
      | Define TRUE caso queria usar debuger no desenvolvimento da aplicação
      |
     */
    AppConfig::DEBUG => true,
    /*
      |-------------------------------------------------------------------------
      | Diretório templates
      |-------------------------------------------------------------------------
      |
      | Define o diretórioa base principal para os templates da aplicação
      |
     */
    AppConfig::DIR_TEMPLATES => dirname(__DIR__) . DS . 'app' . DS . 'Templates',
    /*
      |-------------------------------------------------------------------------
      | Diretório para armazenamento dos arquivos de LOG
      |-------------------------------------------------------------------------F
      |
      | Local default para armazenamento dos arquivos de log da aplicação
      |
     */
    AppConfig::DIR_LOGS => dirname(__DIR__) . DS . 'data' . DS . 'log'
];
