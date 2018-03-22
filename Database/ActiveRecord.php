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

use Exception;
use PDO;
use PDOException;
use PDOStatement;
use Prime\Core\Error;
use Prime\Database\SQL\SqlCriteria;
use Prime\Database\SQL\SqlDelete;
use Prime\Database\SQL\SqlExpressionInterface;
use Prime\Database\SQL\SqlFilter;
use Prime\Database\SQL\SqlInsert;
use Prime\Database\SQL\SqlSelect;
use Prime\Database\SQL\SqlUpdate;
use Prime\Model\DataSource\Repository;

/**
 * @name ActiveRecord
 * @package Prime\Database
 * @since 27/11/2017
 * @author TomSailor
 */
abstract class ActiveRecord {

    /**
     * Armazena os dados do Objeto Row DataGateway
     * @var array 
     */
    protected $data = [];
    protected $oldData = [];
    protected $columns;

    /**
     * Armazena o critéria para consulta
     * @var SqlCriteria
     */
    protected $criteria;
    protected $statement;

    /**
     * Armazena o objeto de erro para controle dos erros na utilização do Model
     * @var Error
     */
    protected $error;

    /**
     * TRUE caso o model carregou algum dado da base de dados
     * @var boolean
     */
    protected $isLoad = FALSE;

    public function __construct($id = null) {
        if (!is_null($id)) {
            $this->load($id);
            $this->data[$this->getPrimaryKey()] = $id;
        }
        $this->error = new Error();
    }

    /**
     * método __clone()
     * executado quando o objeto for clonado.
     * limpa o ID para que seja gerado um novo ID para o clone.
     */
    public function __clone() {
        unset($this->{$this->getPrimaryKey()});
    }

    /**
     * método __set()
     * executado sempre que uma propriedade for atribuída.
     */
    public function __set($prop, $value) {
        // verifica se existe método set_<propriedade>
        if ($value === NULL) {
            unset($this->data[$prop]);
        } else {
            // atribui o valor da propriedade
            $this->data[$prop] = $value;
        }
    }

    /**
     * método __get()
     * executado sempre que uma propriedade for requerida
     */
    public function __get($prop) {
        if (isset($this->data[$prop])) {
            return $this->data[$prop];
        } else {
            return null;
        }
    }

    /**
     * Inicializa internamente o objeto model
     */
    protected function init() {
        $this->data = [];
        $this->oldData = [];
    }

    /**
     * Adiciona os nomes das colunas a serem utilizadas especificadamente na consulta SQL
     * @param string $columnsName
     */
    public function addColumn($columnsName) {
        $this->columns[] = $columnsName;
    }

    private function getColumns() {
        if (count($this->columns)) {
            return $this->columns;
        }
    }

    /**
     * Retorna o nome do campo que é a chave primária da entidade relacional
     * @return string
     */
    public function getPrimaryKey() {
        return constant($this->getClass() . '::PRIMARY_KEY');
    }

    /**
     * Retorna um array e configura o objeto com os dados carregados
     * @param mixed $id O valor da chave primária
     * @return array Os dados carregados
     */
    public function load($id) {
        return $this->loadByField($this->getPrimaryKey(), $id);
    }

    /**
     * Retorna um array e configura o objeto com os dados carregados
     * @param string $field
     * @param mixed $value
     * @return array
     */
    public function loadByField($field, $value) {
        return $this->loadByCriteria(new SqlFilter($field, SqlFilter::EQUALS, $value));
    }

    /**
     * Retorna um array e configura o objeto com os dados carregados
     * @param SqlExpressionInterface $criteria
     * @return array
     */
    public function loadByCriteria(SqlExpressionInterface $criteria) {
        return $this->fetch($this->query($this->getSqlSelectSatatment($criteria)));
    }

    /**
     * Verifica se já uma linha de dados com o ID passado como parâmetro armazenada na
     * base de dados
     * @param mixed $id
     * @return int O número de linhas com o ID passado
     */
    private function exist($id) {
        $repo = new Repository($this->getClass());
        return $repo->count(new SqlFilter($this->getPrimaryKey(), SqlFilter::EQUALS, $id));
    }

    /**
     * Retorna a instrução sql para inserção dos dados 
     * @return string A instrução SQL
     */
    private function getSqlInsertStatement() {
        $sql = new SqlInsert();
        $sql->setEntity($this->getEntity());

        if (empty($this->data[$this->getPrimaryKey()])) {
            $this->data[$this->getPrimaryKey()] = $this->createPK();
        }

        foreach ($this->data as $key => $value) {
            $sql->setRowData($key, $value);
        }
        return $sql->getStatement();
    }

    /**
     * Retorna a instrução sql para atualização dos dados 
     * @return string A intrução sql 
     */
    private function getSqlUpdateStatement() {
        $sql = new SqlUpdate();
        $sql->setEntity($this->getEntity());
        $sql->setCriteria(new SqlFilter($this->getPrimaryKey(), SqlFilter::EQUALS, $this->{$this->getPrimaryKey()}));
        foreach ($this->data as $key => $value) {
            if ($key !== $this->getPrimaryKey() && $this->checkIsNew($key)) {
                $sql->setRowData($key, $value);
            }
        }
        return $sql->getStatement();
    }

    /**
     * Retorna a instrução sql para deleção de dados 
     * @param string $id
     * @return string A instrução sql
     */
    private function getSqlDeleteStatement($id = null) {
        if (is_null($id)) {
            $id = $this->data[$this->getPrimaryKey()];
        }
        $sql = new SqlDelete();
        $sql->setEntity($this->getEntity());
        $sql->setCriteria(new SqlFilter($this->getPrimaryKey(), SqlFilter::EQUALS, $id));
        return $sql->getStatement();
    }

    /**
     * Retorna a instrução sql para carregar dados 
     * @param SqlExpressionInterface $criteria
     * @return string A instrução SQL
     */
    private function getSqlSelectSatatment(SqlExpressionInterface $criteria) {
        $sql = new SqlSelect();
        foreach ($this->getColumns() as $column) {
            $sql->addColumn($column);
        }
        $sql->setEntity($this->getEntity());
        $sql->setCriteria($criteria);
        return $sql->getStatement();
    }

    /**
     * Executa uma instrução SQL, retornando um conjunto de resultados como um 
     * objeto PDOStatement
     * @param string $statement
     * @return \PDOStatement|FALSE
     * @throws PDOException Caso ocorra alguma falha ao executar a instrução SQL
     */
    private function query(string $statement) {
        $conn = $this->getConnection();
        $query = $conn->query($statement);
        if (!$query) {
            throw new PDOException($conn->errorInfo()[2]);
        }
        return $query;
    }

    /**
     * Execute uma instrução SQL e retornar o número de linhas afetadas
     * @param string $statement
     * @return int Retorna o número de linhas que foram modificadas ou excluídas
     * pela declaração SQL. Se nenhuma linha foi afetada, retorna 0;
     */
    private function exec(string $statement) {
        $conn = $this->getConnection();
        return $conn->exec($statement);
    }

    /**
     * Obtém a próxima linha de um conjunto de resultados, retornando um array com índice
     * associativo com os nomes da colunas e seus valores
     * @param PDOStatement $statement
     * @return array
     */
    private function fetch(PDOStatement $statement) {
        return $this->fromArray($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Retorna um array de objetos do tipo Model referente à entidade
     * @param SqlCriteria $criteria
     * @return array
     */
    public function fetchAll(SqlCriteria $criteria) {
        $repo = new Repository($this->getClass());
        return $repo->load($criteria);
    }

    /**
     * Configura os dados interno do Model de acordo com um array passado como os dados
     * @param array $data
     * @return boolean
     */
    private function fromArray($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $this->data[$key] = $value;
                $this->oldData[$key] = $value;
            }
            $this->isLoad = TRUE;
            return TRUE;
        } else {
            $this->isLoad = FALSE;
            return FALSE;
        }
    }

    /**
     * Retorna TRUE caso o model carregou algum dado do Banco de Dados
     * @return boolean
     */
    public function isLoaded() {
        return $this->isLoad;
    }

    /**
     * Retorna TRUE caso o model contenha algum dado
     * @return boolean
     */
    public function isEmpty() {
        if (count($this->data)) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Armazena os dados alterados ou inseridos no objeto
     * @return int O número de linhas afetadas pela instrução SQL
     */
    public function store() {
        if (empty($this->data[$this->getPrimaryKey()]) or ( !$this->exist($this->data[$this->getPrimaryKey()])
                )) {
            $sql = $this->getSqlInsertStatement();
        } else {
            $sql = $this->getSqlUpdateStatement();
        }
        return $this->exec($sql);
    }

    /**
     * Verifica se o valor do campo foi inserido ou alterado, ou seja, verifica
     * se é um valor novo
     * @param string $key O nome do campo
     * @return boolean Retorna TRUE se o valor do campo é novo ou foi alterado
     */
    private function checkIsNew($key) {
        if (isset($this->oldData[$key])) {
            if ($this->data[$key] != $this->oldData[$key]) {
                return TRUE;
            }
        } else {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * 
     * @return array
     */
    public function toArray() {
        return $this->data;
    }

    /**
     * Deleta uma linha de acordo com a PK passada como parâmetro ou configurada anteriormente
     * no objeto
     * @param mixed $id
     * @return int Retorna o número de linhas afetadas pela instrução SQL
     */
    public function delete($id = NULL) {
        return $this->exec($this->getSqlDeleteStatement($id));
    }

    /**
     * Retorna o nome da Tabela
     * @return string
     */
    public function getEntity(): string {
        $class = $this->getClass();
        return constant("{$class}::TABLENAME");
    }

    /**
     * Retorna a transação ativa
     * @return PDO
     * @throws Exception
     */
    protected function getConnection(): PDO {
        if ($conn = Connection::get()) {
            return $conn;
        } else {
            throw new PDOException('Não há transação ativa em ' . $this->getClass());
        }
    }

    /**
     * Retorna o nome da classe de dados
     * @return string O nome da Classe Model do Objeto
     */
    public function getClass(): string {
        return get_class($this);
    }

    /**
     * Retorna o nome da classe de dados
     * @return string O nome da Classe Model do Objeto
     */
    public static function getClassName(): string {
        return get_called_class();
    }

    /**
     * Retorna um valor para ser definido como valor da cheve primária da 
     * entidade(tabela) de acordo com a constante KEY_TYPE definida na classe
     * T{Entidade}
     * @return int | str
     */
    private function createPK() {
        if (isset($this->data[$this->getPrimaryKey()])) {
            return $this->data[$this->getPrimaryKey()];
        }
        if ($this->typePK() == 'MD5') {
            return md5(uniqid($this->getEntity(), TRUE));
        }
        if ($this->typePK() == 'STRING' || $this->typePK() == 'ID') {
            return uniqid();
        }
        if ($this->typePK() == 'SERIAL') {
            $sq1 = new SqlSelect();
            $sq1->addColumn('max(' . $this->getPrimaryKey() . ') as ' . $this->getPrimaryKey());
            $sq1->setEntity($this->getEntity());
            $resu1t = $this->getConnection()->query($sq1->getStatement());
            $row = $resu1t->fetch();
            return ((int) $row[0]) + 1;
        }
    }

    /**
     * Retorna o tipo da PK 
     * @return string se do tipo inteiros ou string
     */
    private function typePK() {
        return constant($this->getClass() . '::KEY_TYPE');
    }

    /**
     * Retorna a última string sql executada
     * @return string
     */
    public function getStatement() {
        return $this->statement;
    }

    /**
     * Adiciona um error ao model
     * @param string $text
     */
    public function addError($text) {
        $this->error->add($text);
    }

    /**
     * Verifica se o objeto model possui erro
     * @return boolean Caso TRUE o objeto possui erro
     */
    public function hasError() {
        return $this->error->hasError();
    }

    /**
     * Retorna um array contendo todos os textos de definição de Erros
     * @return array
     */
    public function getErrors() {
        return $this->error->getErrors();
    }

}
