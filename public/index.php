<?php

use Prime\Server\Http\Application;

/*
  |-------------------------------------------------------------------------
  | BOOTSTRAP
  |-------------------------------------------------------------------------
  |
  | Carrega o arquivo responsavel pelo carregamento das classes e definiçoes
  | basicas iniciais
  |
 */
require '../bootstrap.php';

/*
  |-------------------------------------------------------------------------
  | APLICAÇAO
  |-------------------------------------------------------------------------
  |
  | Inicializa a aplicaçao
 */
$app = Application::getInstance();
/**
 * TRUE caso queira usar o debug, caso FALSE os erros serão lançados como
 * Exception e registrados no log da aplicação
 */
$app->init(true)
        ->finalyze();
