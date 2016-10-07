<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Widget;

use Exception;
use Prime\Model\DataSource\Repository;
use Prime\Model\SQL\SQLCriteria;
use Prime\Model\SQL\SQLGroupBy;
use Prime\Model\SQL\SQLOrderBy;

/**
 * Descrição da Classe Paginator
 * @name Paginator
 * @package Prime\Widget
 * @author Tom Sailor
 * @create 09/06/2016
 * 
 */
class Paginator {

    const PARAM_PAGINA = "page";

    private $pages;
    private $page = 1;
    private $first;
    private $next;
    private $previous;
    private $last;

    /** @var SQLCriteria $criteria */
    private $criteria;
    private $model;
    private $order = null;
    private $group = null;
    private $limit = 10;
    private $total;
    private $records = null;

    /**
     * Cria uma instância de Paginator
     * @param int $page
     */
    public function __construct($page = 1) {
        $this->page = $page;

        if (is_null($page)) {
            $this->page = 1;
            $this->next = $page + 1;
        } else {
            $this->page = $page;
            $this->next = $page + 1;
            $this->previous = $page - 1;
        }
    }

    /**
     * Define o Critéria para definir os filtros da respectiva consulta
     * @param SQLCriteria $criteria
     */
    public function setCriteria(SQLCriteria $criteria) {
        $this->criteria = $criteria;
    }

    /**
     * Define o model responsável para a manipulação de cada recordset de dados
     * retornados
     * @param string $model_name o Nome da classe Model responsável para a 
     * manipulação de cada recordset
     */
    public function setModel($model_name) {
        $this->model = $model_name;
    }

    /**
     * Define os campos para ordenamentos dos registros que serão retornados
     * @param string|SQLOrderBy $field
     * @param string $order ASC ou DESC
     */
    public function setOrder($field, $order = "DESC") {
        if ($field instanceof SQLOrderBy) {
            $this->order = $field->dump();
        } else {
            $this->order = $field . " " . $order;
        }
    }

    /**
     * Define os campos para o agrupamento dos registros retornados
     * @param string|SQLGroupBy $fields
     */
    public function setGroupBy($fields) {
        if ($fields instanceof SQLGroupBy) {
            $this->group = $fields->dump();
        } else {
            $this->group = $fields;
        }
    }

    /**
     * Método load()
     * Recuperar um conjunto de objetos (collection) da base de dados
     * através de um  critério de seleção, e instanciá-los em memória
     * @return Model[] Retorna um array com os objetos do tipo passado como parâmetro
     * ou false caso a criteria não retorne nenhum conteúdo
     * @throws Exception Caso o Model não seja definido
     */
    public function load() {
        if ($this->model) {
            $repository = new Repository($this->model);
        } else {
            throw new Exception("ModelClass não definido");
        }

        if (!$this->criteria) {
            $this->criteria = new SQLCriteria();
        }

        $this->total = $repository->count($this->criteria);

        $this->setTotalRecords($this->limit, $this->total);

        if (!is_null($this->order)) {
            $this->criteria->setOrderBy($this->order);
        }
        if (!is_null($this->group)) {
            $this->criteria->setGroupBy($this->group);
        }

        $this->criteria->setLimit(($this->page - 1) * $this->limit . "," . $this->limit);
        $this->records = $repository->load($this->criteria);
        return $this->records;
    }

    /**
     * Retorna um array de Models do tipo definido no setModel, uma instância
     * para cada recordset retornado
     * @return Model[]
     */
    public function getRecords() {
        if (!is_null($this->records)) {
            return $this->records;
        } else {
            return $this->load();
        }
    }

    /**
     * Método setTotalRecords
     * Define o total de registros que deverão
     * ser exibidos por pagina e o total de registros existentes
     * @param int $numberRecords número de registros por página
     * @param int $totalRecords total de registros existentes
     */
    private function setTotalRecords($numberRecords, $totalRecords) {
        // quantidade de páginas
        $this->pages = ceil($totalRecords / $numberRecords);
        
        if ($this->pages == 1) {
            $this->pages = 1;
            $this->first = 1;
            $this->previous = 1;
            $this->next = 1;
            $this->last = 1;
        } else {
            //$paginas = $paginas;
            if ($this->pages > 1) {
                $this->last = $this->pages;
                $this->first = 1;
            } else {
                $this->first = 1;
                $this->previous = 1;
                $this->next = 1;
                $this->last = 1;
            }
        }
    }

    /**
     * Define a página atual que se encontra
     * @param int $value número da página atual
     */
    public function setPage($value = 1) {
        $this->page = $value;
    }

    /**
     * Método setLimit()
     * Define o limite de registro por página
     * @param int $limit 
     */
    public function setLimit($limit = 10) {
        $this->limit = $limit;
    }
    
    /**
     * Retorna o limite de registro por página
     * @return int
     */
    public function getLimit(){
        return $this->limit;
    }

    /**
     * Retorna o total de registros retornados de acordo com o Crteria passado com os
     * parâmetros da consulta SQL
     * @return int
     */
    public function getTotal() {
        return $this->total;
    }

    /**
     * Retorna o total de páginas
     * @return int 
     */
    public function getTotalPages() {
        return $this->pages;
    }

    /**
     * Retorna o valor da primeira página
     * @return int
     */
    public function getFirstPage() {
        return $this->first;
    }

    /**
     * Retorna o valor da página atual
     * @return int
     */
    public function getCurrentPage() {
        return $this->page;
    }

    /**
     * Retorna o valor da página anterior
     * @return int
     */
    public function getPreviousPage() {
        if($this->previous < 1){
            return 1;
        }
        return $this->previous;
    }

    /**
     * Retorna o valor da última página
     * @return int
     */
    public function getLastPage() {
        return $this->last;
    }

    /**
     * Retorna o valor da próxima página
     * @return int
     */
    public function getNextPage() {
        if ($this->next > $this->last) {
            return $this->last;
        }
        return $this->next;
    }

    /**
     * Retorna a posição do último registro da página
     * @return int
     */
    public function getlastRegistryOfPage() {
        $value = ($this->page * $this->limit);
        if ($this->total < $value) {
            $value = $this->total;
        }
        return $value;
    }

    /**
     * Retorna a posição do primeiro registro da página
     * @return int
     */
    public function getFirstRegistryOfPage() {
        $value = (($this->page - 1) * $this->limit) + 1;

        return $value;
    }

}
