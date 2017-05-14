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
      | Diretório raiz
      |-------------------------------------------------------------------------
      |
      | Define o diretório raiz onde estão os arquivos
      |
     */
    'root' => dirname(__DIR__),
    /*
      |-------------------------------------------------------------------------
      | Diretório raiz da aplicação
      |-------------------------------------------------------------------------
      |
      | Define o diretório raiz da aplicação, que serve de base para todos os
      | demais diretórios básicos da aplicação
      |
     */
    'app' => dirname(__DIR__) . DS . 'App',
    /*
      |-------------------------------------------------------------------------
      | Diretório raiz da aplicação
      |-------------------------------------------------------------------------
      |
      | Define o diretório raiz da aplicação, que serve de base para todos os
      | demais diretórios
      |
     */
    'modules' => dirname(__DIR__) . DS . 'App' . DS . 'Modules',
    /*
      |-------------------------------------------------------------------------
      | Diretório de log
      |-------------------------------------------------------------------------
      |
      | Define o local aonde serão armazenados os logs da aplicação
      |
     */
    'log' => dirname(__DIR__) . DS . 'data' . DS . 'log',
    /*
      |-------------------------------------------------------------------------
      | Diretório dos Templates
      |-------------------------------------------------------------------------
      |
      | Define o local aonde serão armazenados os templates que serão utilizados na aplicação
      |
     */
    'templates' => dirname(__DIR__) . DS . 'App' . DS . 'Templates',
    /*
      |-------------------------------------------------------------------------
      | Diretório de cache
      |-------------------------------------------------------------------------
      |
      | Define o local aonde serão armazenados os caches dos templates da aplicação
      |
     */
    'cache' => dirname(__DIR__) . DS . 'data' . DS . 'cache',
    /*
      |-------------------------------------------------------------------------
      | Diretório de armazenamento
      |-------------------------------------------------------------------------
      |
      | Define o local aonde serão armazenados arquivos diversos como imagens,
      | ícones ou conteúdo diversos, podendo ser subdividido a critério do
      | utilizador
     */
    'storage' => dirname(__DIR__) . DS . 'public' . DS . 'storage',
]);
