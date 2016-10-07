<?php

use App\Application;

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
  | ROTAS
  |-------------------------------------------------------------------------
  |
  | Carrega o arquivo contento as definiçoes de rota
  |
 */
$routes = require_once '../config/routes.php';



/*
  |-------------------------------------------------------------------------
  | APLICAÇAO
  |-------------------------------------------------------------------------
  |
  | Inicializa a aplicaçao
 */
$app = Application::getInstance($routes);
/**
 * //TRUE caso queira usar o debug, caso FALSE os erros serão lançados como
 * Exception e registrados no log da aplicação
 */
$app->init(true);

$app->finalyze();

