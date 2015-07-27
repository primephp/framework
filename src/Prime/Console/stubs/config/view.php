<?php

$cacheDirectory = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'cache';

/*
  |-------------------------------------------------------------------------
  | Configuração para uso do Twig Template
  |-------------------------------------------------------------------------
  |
  | Define as configurações padrão para o uso no TWIG
  |
 */
return [
    'debug' => true,
    'charset' => 'utf-8',
    'base_template_class' => 'Twig_Template',
    'cache' => $cacheDirectory,
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true,
    'optimizations' => -1
];
