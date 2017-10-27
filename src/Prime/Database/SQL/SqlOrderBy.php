<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prime\Database\SQL;

/**
 * Classifica o conjunto de resultados em ordem ascendente ou descendente.
 * Classificando por padrão em ordem creascente.
 *
 * @author Tom Sailor
 */
class SqlOrderBy extends AbstractExpression {

    const DESC_OPERATOR = " desc ";
    const ASC_OPERATOR = " asc ";

    /**
     * @var array
     */
    private $struct = [];

    /**
     * @var array
     */
    private $order = [];

    /**
     * Cria um novo objeto para ordenar os resultados da consulta SQL
     * @param array $column
     * @param string $order 
     */
    public function __construct($column = NULL, $order = '') {
        if (is_array($column) || is_string($column)) {
            $this->add($column, $order);
        }
    }

    /**
     * Adiciona um array de colunas para ordenamento
     * @param array $columns Um array contendo os nomes da colunas
     * @param string $order Tipo de ordenamento utilizado para todos os campos
     * adicionados
     */
    public function addArray(array $columns, string $order = self::ASC_OPERATOR) {
        foreach ($columns as $value) {
            $this->add($value, $order);
        }
    }

    /**
     * Adiciona um nome de campo para ordenamento
     * @param string $column Nome da coluna a ser adicionado
     * @param string $order Tipo de ordenamento ASC ou DESC
     * @return bool Retorna true caso seja um valor válido e false caso não seja
     * um valor válido
     */
    public function add(string $column, string $order = self::ASC_OPERATOR): bool {
        if (is_string($column) && !is_numeric($column)) {
            $this->struct = $column;
            $this->order = $order;
            return true;
        }
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function dump(): string {
        $dump = '';
        $total = count($this->struct);
        for ($index = 0; $index < $total; $index++) {
            $dump .= $this->struct[$index] . ' ' . $this->order[$index];
            if ($index < ($total - 1)) {
                $dump .= ', ';
            }
        }
        return $dump;
    }

}
