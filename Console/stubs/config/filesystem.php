<?php

use Prime\FileSystem\Filesystem;

/*
  |-------------------------------------------------------------------------
  | Arquivo de Configuração filesystem
  |-------------------------------------------------------------------------
  |
  | Define os principais diretórios que serão utilizados pela aplicação, tais
  | como armazenamento de log, cache, arquivos diversos
  |
 */

$root = dirname(__DIR__);
$app = 'app';
$public = 'public';
$data = 'data';
$modules = 'Modules';
$templates = 'Templates';
$storage = 'storage';
$log = 'log';
$cache = 'cache';

Filesystem::addPaths([
    /*
      |-------------------------------------------------------------------------
      | Diretório raiz
      |-------------------------------------------------------------------------
      |
      | Define o diretório raiz onde estão os arquivos
      |
     */
    'root' => $root,
    /*
      |-------------------------------------------------------------------------
      | Diretório raiz da aplicação
      |-------------------------------------------------------------------------
      |
      | Define o diretório raiz da aplicação, que serve de base para todos os
      | demais diretórios básicos da aplicação
      |
     */
    'app' => $root. DS . $app,
    /*
      |-------------------------------------------------------------------------
      | Diretório raiz da aplicação
      |-------------------------------------------------------------------------
      |
      | Define o diretório raiz da aplicação, que serve de base para todos os
      | demais diretórios
      |
     */
    'modules' => $root . DS . $app . DS . $modules,
    /*
      |-------------------------------------------------------------------------
      | Diretório de log
      |-------------------------------------------------------------------------
      |
      | Define o local aonde serão armazenados os logs da aplicação
      |
     */
    'log' => $root . DS . $data . DS . $log,
    /*
      |-------------------------------------------------------------------------
      | Diretório dos Templates
      |-------------------------------------------------------------------------
      |
      | Define o local aonde serão armazenados os templates que serão utilizados na aplicação
      |
     */
    'templates' => $root . DS . $app . DS . $templates,
    /*
      |-------------------------------------------------------------------------
      | Diretório de cache
      |-------------------------------------------------------------------------
      |
      | Define o local aonde serão armazenados os caches dos templates da aplicação
      |
     */
    'cache' => $root . DS . $data . DS . $cache,
    /*
      |-------------------------------------------------------------------------
      | Diretório de armazenamento
      |-------------------------------------------------------------------------
      |
      | Define o local aonde serão armazenados arquivos diversos como imagens,
      | ícones ou conteúdo diversos, podendo ser subdividido a critério do
      | utilizador
     */
    'storage' => $root . DS . $public . DS . $storage,
]);
