<?php

namespace Prime\Model\DataSource;

use ArrayObject;
use Exception;
use PDOException;
use Prime\Model\SQL\SQLDelete;
use Prime\Model\SQL\SQLExpression;
use Prime\Model\SQL\SQLSelect;
use Prime\Model\SQL\SQLUpdate;

/**
 * Classe Repository
 * @name Repository
 * @package Prime\Model\DataSource
 * esta classe provê os métodos necessários para manipular coleções de objetos.
 */
final class Repository {

    /**
     * @name $class
     * @var Class 
     */
    private $class; // nome da classe manipulada pelo repositório
    /**
     * @name $columns
     * @access private
     * @var [array] = colunas a serem utilizadas para a recuperação dos dados 
     */
    private $columns;

    /**
     * @var SQLSelect 
     */
    private $sql;

    /** método __construct()
     * instancia um Repositório de objetos
     * @param $class Classe dos Objetos
     */
    function __construct($class) {
        if (is_object($class)) {
            /* @var $class Model */
            $class = $class->getClass();
        }
        if (class_exists($class)) {
            $this->class = $class;
        } else {
            trigger_error("Classe " . $class . " não existe", E_USER_ERROR);
        }
    }

    /**
     * Recuperar um conjunto de objetos (ArrayObject) da base de dados
     * através de um critério de seleção, e instanciá-los em memória
     * @param SQLExpression $criteria Criteria de consulta
     * @return ArrayObject Retorna um array com os objetos do tipo passado como parâmetro
     * ou false caso a criteria não retorne nenhum conteúdo
     * @throws PDOException
     */
    function load(SQLExpression $criteria) {
        $sql = new SQLSelect();
        if (is_array($this->columns)) {
            foreach ($this->columns as $value) {
                $sql->addColumn($value);
            }
        } else {
            $sql->addColumn('*');
        }
        $sql->setEntity(constant($this->class . '::TABLENAME'));
        $sql->setCriteria($criteria);
        if ($conn = Connection::get()) {
            $result = $conn->query($sql->getStatement());
            $this->sql = $sql->getStatement();
            $results = new ArrayObject();

            if ($result) {
                // percorre os resultados da consulta, retornando um objeto
                while ($row = $result->fetchObject($this->class)) {
                    // armazena no array $results;
                    $results->append($row);
                }
            }
            /* @var $this->class[] */
            return $results;
        } else {
            throw new PDOException('Não há conexão ativa');
        }
    }

    /**
     * método delete()
     * Excluir um conjunto de objetos (collection) da base de dados
     * através de um critério de seleção.
     * @param $criteria = objeto do tipo TCriteria
     */
    function delete(SQLExpression $criteria) {
        // instancia instrução de DELETE
        $sql = new SQLDelete;
        $sql->setEntity(constant($this->class . '::TABLENAME'));

        // atribui o critério passado como parâmetro
        $sql->setCriteria($criteria);
        $this->sql = $sql->getStatement();
        // obtém transação ativa
        if ($conn = Connection::get()) {
            $result = $conn->exec($sql->getStatement());
            return $result;
        } else {
            // se não tiver transação, retorna uma exceção
            throw new Exception('Não há transação ativa!!');
        }
    }

    /**
     * método update()
     * Atualiza registros de um repositório de acordo com o parâmetro critéria passado
     * a partir de um array associativo de nome de colunas e os valores que devem
     * receber
     * @param SQLExpression $criteria
     * @param array $columns Array associativo com o nome da coluna e seus valores
     * @return int $num Valores de linhas afetadas pela instrução 
     */
    public function update(SQLExpression $criteria, $columns = []) {
        $sql = new SQLUpdate();
        $sql->setEntity(constant($this->class . '::TABLENAME'));
        $sql->setCriteria($criteria);
        //verifica se foi passado um array com a coluna e o valor a ser definido
        if (count($columns) > 0) {
            //define as colunas e valores a serem atualizados
            foreach ($columns as $key => $value) {
                $sql->setRowData($key, $value);
            }
            if ($conn = Connection::get()) {
                $result = $conn->exec($sql->getStatement());
                return $result;
            } else {
                // se não tiver transação, retorna uma exceção
                throw new Exception('Não há transação ativa!!');
            }
        } else {
            throw new Exception('Não foram definidas as colunas para atualização.');
        }
    }

    /**
     * método count()
     * Retorna a quantidade de objetos da base de dados
     * que satisfazem um determinado critério de seleção.
     * @param $criteria = objeto do tipo TCriteria
     */
    function count(SQLExpression $criteria) {

        // instancia instrução de SELECT
        $sql = new SQLSelect();
        $sql->addColumn('count(*)');
        $sql->setEntity(constant($this->class . '::TABLENAME'));

        // atribui o critério passado como parâmetro
        $sql->setCriteria($criteria);

        $this->sql = $sql->getStatement();
        if ($conn = Connection::get()) {
            $row = array();
            $result = $conn->query($sql->getStatement());
            if ($result) {
                $row = $result->fetch();
            }
            return $row[0];
        } else {
            // se não tiver transação, retorna uma exceção
            throw new Exception('Não há transação ativa!!');
        }
    }

    /**
     * Métod addColumn
     * Define a coluna ou colunas a serem utilizada
     * no repositório
     * @param [string] $columnName 
     */
    public function addColumn($column) {
        $this->columns[] = $column;
    }

    /**
     * Método getColumns
     * retorna um array com os valores das colunas ou 
     * um string '*'
     * @return String
     */
    private function getColumns() {
        return explode(",", $this->columns);
    }

    /**
     * Retorna a instrução sql executada
     * @return string
     */
    public function getSqlStatement() {
        return $this->sql;
    }

}
