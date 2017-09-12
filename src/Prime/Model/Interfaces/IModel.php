<?php

namespace Prime\Model\Interfaces;

use Prime\Model\SQL\SQLExpression;

/**
 * Interface IModel
 * Esta interface especifica quais métodos e variáveis as classes de Modelo
 * de Dados devem implementar, sem ter que definir como esses métodos serão tratados
 * @name IModel
 * @package Prime\Model\Interfaces
 * @version 1.0
 * @author TomSailor
 * @since 08/10/2011
 * @access public
 */
interface IModel {

    public function __construct($id = null);

    /**
     * método fromArray
     * preenche os dados do objeto com um array
     */
    public function fromArray($data);

    /**
     * método toArray
     * retorna os dados do objeto como array
     */
    public function toArray();

    /**
     * método store()
     * armazena o objeto na base de dados e retorna
     * o número de linhas afetadas pela instrução SQL (zero ou um)
     */
    public function store();

    /**
     * método load()
     * recupera (retorna) um objeto da base de dados
     * através de seu ID e instancia ele na memória
     * @param $id = ID do objeto
     */
    public function load($id);

    /**
     *
     * @param <type> $field
     * @param <type> $value
     */
    public function loadByField($field, $value);

    /**
     * Método loadByCriteria
     * Carrega o registro de acordo com o Critério passado como 
     * Parâmetro
     */
    public function loadByCriteria(SQLExpression $criteria);

    /**
     * método delete()
     * exclui um objeto da base de dados através de seu ID.
     * @param $id = ID do objeto
     */
    public function delete($id = NULL);

    public function addColumns($columnsName);
}
