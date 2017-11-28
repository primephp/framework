<?php

/*
 * The MIT License
 *
 * Copyright 2017 TomSailor.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Prime\Database;

use Monolog\Logger;
use PDOStatement;
use Prime\Database\SQL\ExpressionInterface;
use Prime\Database\SQL\SqlColumn;
use Prime\Database\SQL\SqlSelect;
use Prime\DataStructure\ArrayTrait;
use Prime\Model\DataSource\Repository;

/**
 * @name ActiveRecord
 * @package Prime\Database
 * @since 27/11/2017
 * @author TomSailor
 */
abstract class ActiveRecord
{

    use ArrayTrait;

    /**
     * Armazena a conexão com a base de dados
     * @var Connection
     */
    protected $connection = null;

    /**
     * O nome do campo que é a chave primária da tabela
     * @var string
     */
    protected $pk = 'id';

    /**
     * Armazena um array contendo todos os objetos do tipo sqlcolumn para
     * serem utilizados na instrução sql
     * @var SqlColumn[]
     */
    protected $columns = [];

    /**
     * Um array armazenando os campos e os valores recuperados da base de dados
     * @var array 
     */
    protected $data = [];

    /**
     *
     * @var array 
     */
    protected $array = [];
    protected $isLoad = false;
    protected $criteria;
    protected $statement;
    private $log;

    public static function load(string $id)
    {
        $r = new Repository('');
    }

    public function __construct(array $array = array())
    {

        $this->init();
    }

    protected function init()
    {
        $log = new Logger('teste');
    }

    private function fieldNewValue($key)
    {
        if (isset($this->data[$key])) {
            if ($this->array[$key] != $this->data[$key]) {
                return TRUE;
            }
        } else {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Retorna o nome da Tabela
     * @return string
     */
    public function getEntity()
    {
        $class = $this->getClass();
        return constant("{$class}::TABLENAME");
    }

    /**
     * Retorna o nome do campo que é a chave primária da entidade relacional
     * @return string
     */
    public function pkName()
    {
        return constant($this->getClass() . '::PRIMARY_KEY');
    }

    private function pkType()
    {
        return constant($this->getClass() . '::KEY_TYPE');
    }

    private function createPk()
    {
        
    }

    public function loadByCriteria(ExpressionInterface $criteria)
    {
        $pdo = new PDOStatement();
    }

    /**
     * Retorna um array contendo todas as colunas configuradas para serem utilizadas
     * na instrução SQL
     * @return SqlColumn[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }
    
    protected function exec(string $sql){
        
    }

    private function select(ExpressionInterface $criteria)
    {
        $sql = new SqlSelect($this->getEntity());
        $sql->addColumn($this->columns);
    }

    private function update()
    {
        
    }

    private function insert()
    {
        
    }

    public function store()
    {
        
    }

    public function delete($id)
    {
        
    }

    public function getClass()
    {
        return get_class($this);
    }

    public static function getClassName()
    {
        return get_called_class();
    }

}
