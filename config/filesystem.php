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
Filesystem::addPaths([
    /*
      |-------------------------------------------------------------------------
      | Diretório raiz da aplicação
      |-------------------------------------------------------------------------
      |
      | Define o diretório raiz da aplicação, que serve de base para todos os
      | demais diretórios
      |
     */
    'root' => dirname(__DIR__),
    /*
      |-------------------------------------------------------------------------
      | Diretório de log
      |-------------------------------------------------------------------------
      |
      | Define o local aonde serão armazenados os logs da aplicação
      |
     */
    'log' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'log',
    /*
      |-------------------------------------------------------------------------
      | Diretório dos Templates
      |-------------------------------------------------------------------------
      |
      | Define o local aonde serão armazenados os templates que serão utilizados na aplicação
      |
     */
    'templates' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src'. DIRECTORY_SEPARATOR .'App' . DIRECTORY_SEPARATOR . 'Templates',
    /*
      |-------------------------------------------------------------------------
      | Diretório de cache
      |-------------------------------------------------------------------------
      |
      | Define o local aonde serão armazenados os caches dos templates da aplicação
      |
     */
    'cache' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'cache',
    /*
      |-------------------------------------------------------------------------
      | Diretório de armazenamento
      |-------------------------------------------------------------------------
      |
      | Define o local aonde serão armazenados arquivos diversos como imagens,
      | ícones ou conteúdo diversos, podendo ser subdividido a critério do
      | utilizador
     */
    'storage' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'storage',
]);
