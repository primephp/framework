<?php

$database['default'] = [
    /*
      |-------------------------------------------------------------------------
      | Drive de Conexão
      |-------------------------------------------------------------------------
      |
      | Define o drive de conexão à base de dados, os valores aceitos são:
      | pgsql - mysql - sqlite - ibase - oci - mssql
      |
      |
     */
    'type' => 'mysql',
    /*
      |-------------------------------------------------------------------------
      | Usuário do banco de dados
      |-------------------------------------------------------------------------
      |
      | Define o nome do usuário com permissão de acesso ao banco de dados
      |
     */
    'user' => 'dbusername',
    /*
      |-------------------------------------------------------------------------
      | Senha do Usuário
      |-------------------------------------------------------------------------
      |
      | Define a senha de acesso do usuário com permissão de acesso ao BD
      |
     */
    'pass' => 'password',
    /*
      |-------------------------------------------------------------------------
      | Nome da Base de Dados
      |-------------------------------------------------------------------------
      |
      | Nome do banco de dados que a aplicação utilizará
      |
     */
    'name' => 'dbname',
    /*
      |-------------------------------------------------------------------------
      | HostName
      |-------------------------------------------------------------------------
      |
      | IP do host aonde está hospedado a base de dados a qual se quer acessar
      |
     */
    'host' => 'dbhost',
    /*
      |-------------------------------------------------------------------------
      | Porta
      |-------------------------------------------------------------------------
      |
      | Porta para acesso à base de dados
      |
     */
    'port' => 'dbport',
    /*
      |-------------------------------------------------------------------------
      | Charset
      |-------------------------------------------------------------------------
      |
      | Porta para acesso à base de dados
      |
     */
    'charset' => 'dbcharset'
];

//conexao com sqlite
$database['database2'] = [
    'type' => 'sqlite',
    'user' => null,
    'pass' => null,
    'name' => '/path/mydb.sq3',
    'params' => [
        PDO::ATTR_PERSISTENT => true
    ]
];
//conexão com ODBC
$database['database3'] = [
    'type' => 'odbc',
    'params' => [
        PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY,
        PDO::ATTR_CASE => PDO::CASE_LOWER,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ],
];
//conexao com mssql
$database['database4'] = [
    'type' => 'mssql',
    'host' => 'localhost',
    'user' => 'username',
    'pass' => 'minhasenha',
    'name' => 'dbname',
        /* 'params' => array(
          PDO::ATTR_PERSISTENT => true, //conexão persistente
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
          ) */
];

return $database;
