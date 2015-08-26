<?php

namespace Prime\Model\DataSource;

use Exception;
use PDO;
use PDOException;
use PDOStatement;
use Prime\Model\Interfaces\IModel;
use Prime\Model\SQL\SQLCriteria;
use Prime\Model\SQL\SQLDelete;
use Prime\Model\SQL\SQLExpression;
use Prime\Model\SQL\SQLFilter;
use Prime\Model\SQL\SQLInsert;
use Prime\Model\SQL\SQLSelect;
use Prime\Model\SQL\SQLUpdate;

/**
 * classe Model
 * Esta classe provê os métodos necessários para persistir e
 * recuperar objetos da base de dados (Active Record)
 * @name Record
 * @package Prime\Model\DataSource
 * @version 2.0
 * @author Pablo Daglio / TomSailor
 * @since 18/08/2011
 * @access public
 */
abstract class Model implements IModel
{

    /**
     * Armazena os dados do Objeto Row DataGateway
     * @var array 
     */
    protected $data = [];
    protected $oldData = [];
    protected $columns;
    protected $criteria;

    public function __construct($id = null)
    {
        if (!is_null($id)) {
            $this->load($id);
            $this->data[$this->getPrimaryKey()] = $id;
        }
    }

    /**
     * método __clone()
     * executado quando o objeto for clonado.
     * limpa o ID para que seja gerado um novo ID para o clone.
     */
    public function __clone()
    {
        unset($this->{$this->getPrimaryKey()});
    }

    /**
     * método __set()
     * executado sempre que uma propriedade for atribuída.
     */
    public function __set($prop, $value)
    {
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
    public function __get($prop)
    {
        if (isset($this->data[$prop])) {
            return $this->data[$prop];
        } else {
            return null;
        }
    }

    /**
     * Inicializa internamente o objeto model
     */
    protected function init()
    {
        $this->data = [];
        $this->oldData = [];
    }

    /**
     * Adiciona os nomes das colunas a serem utilizadas especificadamente na consulta SQL
     * @param type $columnsName
     */
    public function addColumns($columnsName)
    {
        $this->columns[] = $columnsName;
    }

    private function getColumns()
    {
        if (is_array($this->columns)) {
            $total = count($this->columns);
            for ($index = 0; $index < $total; $index++) {
                
            }
        } else {
            return '*';
        }
    }

    /**
     * Retorna o nome do campo que é a chave primária da entidade relacional
     * @return string
     */
    public function getPrimaryKey()
    {
        return constant($this->getClass() . '::PRIMARY_KEY');
    }

    /**
     * Retorna um array e configura o objeto com os dados carregados
     * @param mixed $id O valor da chave primária
     * @return array Os dados carregados
     */
    public function load($id)
    {
        return $this->loadByField($this->getPrimaryKey(), $id);
    }

    /**
     * Retorna um array e configura o objeto com os dados carregados
     * @param string $field
     * @param mixed $value
     * @return array
     */
    public function loadByField($field, $value)
    {
        return $this->loadByCriteria(new SQLFilter($field, SQLFilter::IS_EQUAL, $value));
    }

    /**
     * Retorna um array e configura o objeto com os dados carregados
     * @param SQLExpression $criteria
     * @return array
     */
    public function loadByCriteria(SQLExpression $criteria)
    {
        return $this->fetch($this->preLoad($criteria));
    }

    /**
     * Verifica se já uma linha de dados com o ID passado como parâmetro armazenada na
     * base de dados
     * @param mixed $id
     * @return int O número de linhas com o ID passado
     */
    private function exist($id)
    {
        $repo = new Repository($this->getClass());
        return $repo->count(new SQLFilter($this->getPrimaryKey(), SQLFilter::IS_EQUAL, $id));
    }

    /**
     * Executa a instrução SQL, retornando um conjunto de resultados como um objeto PDOStatement
     * @param SQLExpression $criteria
     * @return \PDOStatement
     */
    private function preLoad(SQLExpression $criteria)
    {
        $sql = new SQLSelect();
        $sql->addColumn($this->getColumns());
        $sql->setEntity($this->getEntity());
        $sql->setCriteria($criteria);

        $conn = $this->getConnection();

        return $conn->query($sql->getStatement());
    }

    /**
     * Obtém a próxima linha de um conjunto de resultados, retornando um array com índice
     * associativo com os nomes da colunas e seus valores
     * @param PDOStatement $statement
     * @return array
     */
    private function fetch(PDOStatement $statement)
    {
        return $this->fromArray($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Retorna um array de objetos do tipo Model referente à entidade
     * @param SQLCriteria $criteria
     * @return array
     */
    public function fetchAll(SQLCriteria $criteria)
    {
        $repo = new Repository($this->getClass());
        return $repo->load($criteria);
    }

    /**
     * Configura os dados interno do Model de acordo com um array passado como os dados
     * @param array $data
     * @return boolean
     */
    public function fromArray($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $this->data[$key] = $value;
                $this->oldData[$key] = $value;
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Armazena os dados alterados ou inseridos no objeto
     * @return int O número de linhas afetadas pela instrução SQL
     */
    public function store()
    {
        if (empty($this->data[$this->getPrimaryKey()]) or ( !$this->exist($this->data[$this->getPrimaryKey()])
                )) {
            $sql = $this->insert();
        } else {
            $sql = $this->update();
        }

        $conn = $this->getConnection();
        return $conn->exec($sql->getStatement());
    }

    /**
     * Atualiza um Row Datagateway
     * @return SQLInsert SQLInsert Statement
     */
    private function insert()
    {
        $sql = new SQLInsert();
        $sql->setEntity($this->getEntity());

        if (empty($this->data[$this->getPrimaryKey()])) {
            $this->data[$this->getPrimaryKey()] = $this->createPK();
        }

        foreach ($this->data as $key => $value) {
            $sql->setRowData($key, $value);
        }
        return $sql;
    }

    /**
     * Atualiza um Row DataGateway
     * @return SQLUpdate SQLUpdate Statement
     */
    private function update()
    {
        $sql = new SQLUpdate();
        $sql->setEntity($this->getEntity());
        $sql->setCriteria(new SQLFilter($this->getPrimaryKey(), SQLFilter::IS_EQUAL, $this->{$this->getPrimaryKey()}));
        foreach ($this->data as $key => $value) {
            if ($key !== $this->getPrimaryKey() && $this->fieldNewValue($key)) {
                $sql->setRowData($key, $value);
            }
        }
        return $sql;
    }

    private function fieldNewValue($key)
    {
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
    public function toArray()
    {
        return $this->data;
    }

    /**
     * Deleta uma linha de acordo com a PK passada como parâmetro ou configurada anteriormente
     * no objeto
     * @param mixed $id
     * @return int Retorna o número de linhas afetadas pela instrução SQL
     */
    public function delete($id = NULL)
    {
        if (is_null($id)) {
            $id = $this->data[$this->getPrimaryKey()];
        }
        $sql = new SQLDelete();
        $sql->setEntity($this->getEntity());
        $sql->setCriteria(new SQLFilter($this->getPrimaryKey(), SQLFilter::IS_EQUAL, $id));

        $conn = $this->getConnection();
        return $conn->exec($sql->getStatement());
    }

    /**
     * Retorna o nome da Tabela
     * @return str
     */
    public function getEntity()
    {
        $class = $this->getClass();
        return constant("{$class}::TABLENAME");
    }

    /**
     * Retorna a transação ativa
     * @return PDO
     * @throws Exception
     */
    protected function getConnection()
    {
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
    public function getClass()
    {
        return get_class($this);
    }

    /**
     * Retorna o nome da classe de dados
     * @return string O nome da Classe Model do Objeto
     */
    public static function getClassName()
    {
        return get_called_class();
    }

    /**
     * Retorna um valor para ser definido como valor da cheve primária da 
     * entidade(tabela) de acordo com a constante KEY_TYPE definida na classe
     * T{Entidade}
     * @return int | str
     */
    private function createPK()
    {
        if (isset($this->data[$this->getPrimaryKey()])) {
            return $this->data[$this->getPrimaryKey()];
        }
        if ($this->typePK() == 'MD5') {
            return md5(uniqid($this->getEntity(), TRUE));
        }
        if ($this->typePK() == 'SERIAL') {
            $sq1 = new SQLSelect();
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
    private function typePK()
    {
        return constant($this->getClass() . '::KEY_TYPE');
    }

}
