<?php

/*
 * The MIT License
 *
 * Copyright 2015 devel4.
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

namespace Prime\Database\Metadata;

use PDO;
use Prime\Database\Connection;
use UnexpectedValueException;

/**
 * Classe Metadata
 * @name Metadata
 * @package Prime\Database\Metadata
 * @since 22/07/2015
 * @author Elton Luiz
 */
class EntityMetadata
{

    /**
     *
     * @var PDO
     */
    private $conn;
    private $entity;
    private $totalColumns = 0;
    private $metadata = NULL;
    private $types = [];

    public function __construct($entity = NULL, $database = 'default')
    {
        $this->entity = $entity;
        Connection::open($database);
        $this->conn = Connection::get($database);
        $this->setTypes();
        $this->prepare();
    }

    private function setTypes()
    {
        $this->types = [
            //text
            'VARCHAR' => 'string',
            'varchar' => 'string',
            'bpchar' => 'string',
            'VAR_STRING' => 'string',
            'BLOB' => 'string',
            'STRING' => 'string',
            //integer
            'TINY' => 'int',
            'LONG' => 'int',
            'int4' => 'int',
            'int' => 'int',
            'integer' => 'int',
            'FLOAT' => 'float',
            'float' => 'float',
            'float8' => 'float',
            'double' => 'float',
            'DOUBLE' => 'float',
            //datetime
            'DATE' => 'date',
            'DATETIME' => 'datetime',
            'timestamp' => 'datetime',
            'TIMESTAMP' => 'datetime',
            'date' => 'date',
            'time' => 'time'
        ];
    }

    private function prepare()
    {
        $table = $this->entity;
        $query = "SELECT * FROM $table LIMIT 1";

        $conn = $this->conn;

        $statement = $conn->query($query);

        if (!$statement) {
            throw new UnexpectedValueException('Entidade Relacional não encontrada no banco de dados.');
        }

        $this->totalColumns = $statement->columnCount();

        for ($index = 0; $index < $this->totalColumns; $index++) {
            $column = [];
            $meta = $statement->getColumnMeta($index);
            $column['name'] = $meta['name'];
            $column['type'] = $this->types[$meta['native_type']];

            $len = (int) filter_var($meta['len'], FILTER_SANITIZE_NUMBER_INT);
            $precision = (int) filter_var($meta['precision'], FILTER_SANITIZE_NUMBER_INT);

            if ($len == '-1') {
                $column['size'] = $precision;
            } else {
                $column['size'] = $len;
            }

            if (isset($meta['flags'])) {
                if (array_search('not_null', $meta['flags'])) {
                    $column['null'] = true;
                } else {
                    $column['null'] = false;
                }
                if (array_search('primary_key', $meta['flags'])) {
                    $column['pkey'] = true;
                } else {
                    $column['pkey'] = false;
                }
                if (array_search('multiple_key', $meta['flags'])) {
                    $column['fkey'] = true;
                } else {
                    $column['fkey'] = false;
                }
            }
            $columns[] = $column;
        }
        $this->metadata = $columns;
    }

    public function getEntityName()
    {
        return $this->entity;
    }

    public function getTotalColumns()
    {
        return $this->totalColumns;
    }

    public function get()
    {
        return $this->metadata;
    }

}
