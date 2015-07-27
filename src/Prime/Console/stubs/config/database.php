<?php

return [
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
    'type' => 'DbDrive',
    /*
      |-------------------------------------------------------------------------
      | Usuário do banco de dados
      |-------------------------------------------------------------------------
      |
      | Define o nome do usuário com permissão de acesso ao banco de dados
      |
     */
    'user' => 'DbUser',
    /*
      |-------------------------------------------------------------------------
      | Senha do Usuário
      |-------------------------------------------------------------------------
      |
      | Define a senha de acesso do usuário com permissão de acesso ao BD
      |
     */
    'pass' => 'DbPassword',
    /*
      |-------------------------------------------------------------------------
      | Nome da Base de Dados
      |-------------------------------------------------------------------------
      |
      | Nome do banco de dados que a aplicação utilizará
      |
     */
    'name' => 'DbName',
    /*
      |-------------------------------------------------------------------------
      | HostName
      |-------------------------------------------------------------------------
      |
      | IP do host aonde está hospedado a base de dados a qual se quer acessar
      |
     */
    'host' => 'DbHost', 
    /*
      |-------------------------------------------------------------------------
      | Porta
      |-------------------------------------------------------------------------
      |
      | Porta para acesso à base de dados
      |
     */
    'port' => 'DbPort'  
  
];
