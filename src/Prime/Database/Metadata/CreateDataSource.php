<?php

/*
 * The MIT License
 *
 * Copyright 2015 Elton Luiz.
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

namespace Prime\Model\DataSource\Metadata;

use \Prime\Model\DataSource\Model;

/**
 * Classe CreateDataSource
 * @name CreateDataSource
 * @package Prime\Model\DataSource\Metadata
 * @since 22/07/2015
 * @author Elton Luiz
 */
class CreateDataSource
{

    private $entity;
    private $metadata;
    private $modelNamespace = 'App\DataSource';
    private $className = NULL;
    private $parentClass = NULL;

    public function __construct($tableName)
    {
        $this->entity = $tableName;
        $meta = new EntityMetadata($tableName);
        $this->metadata = $meta->get();
        $this->className = $this->className(ucfirst(strtolower($tableName)));
        $this->parentClass = Model::class;
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function setNamespace($namespace)
    {
        $this->modelNamespace = $namespace;
    }

    private function className($tableName)
    {
        $string = ucfirst(strtolower($tableName));
        $num = strlen($string);
        $uCase = $string;
        // se a última letra for "S"
        if (substr($string, $num - 1) === "s") {
            // se as três últimas letras for "OES"
            if (substr($string, $num - 3) === "oes") {
                $string = substr_replace($string, "ao", $num - 3);
            } else
            // se as duas últimas letras for "NS"
            if (substr($string, $num - 2) === "ns") {
                $string = substr_replace($string, "m", $num - 2);
                // do contrário só remove o "S"
            } else {
                $string = substr_replace($string, "", $num - 1);
            }
            $uCase = $string;
        }
        //montando o nome da classe
        if (strpos($uCase, "_")) {
            $fragments = explode("_", $uCase);
            $uCase = "";
            foreach ($fragments as $fragment) {
                $uCase .= ucfirst($fragment);
            }
        }
        return $uCase . 'DataSource';
    }

    private function getHeader()
    {
        $classeName = $this->getClassName();
        return
                "
                namespace {$this->modelNamespace};\n 
                
                use {$this->parentClass};\n
                
                /**
                *@name $classeName '
                *@package {$this->modelNamespace}
		*@author Elton Luiz
		*@create " . date('d/m/Y') . "
                *Objetiva facilitar o desenvolvimento com as IDE padroes de mercado.
		*/\n
                
                abstract class $classeName extends Model{
                    
                    ";
    }

    public function getConstants()
    {
        $constFields = "const TABLENAME = \"{$this->entity}\";\n";

        $pk = NULL;
        $pkType = NULL;
        foreach ($this->metadata as $value) {
            $constFields .= "\t\t"
                    . "const FIELD_" . strtoupper($value['name']) . " = \"{$value['name']}\";\n";
            if (isset($value['pkey'])) {
                $pk = $value['name'];
                $size = filter_var($value['size'], FILTER_SANITIZE_NUMBER_INT);
                if ($value['type'] == 'int') {
                    $pkType = 'SERIAL';
                } else {
                    if ($size == 32) {
                        $pkType = 'MD5';
                    } else
                    if ($size >= 13) {
                        $pkType = 'ID';
                    }
                }
            }
        }
        $constFields .= "\t\tconst PRIMARY_KEY = '$pk';\n";
        $constFields .= "\t\tconst KEY_TYPE = '$pkType';#SERIAL|MD5|ID\n";
        return $constFields;
    }

    public function getSetterGetter(array $field)
    {
        $methods = new CreateSetterGetter($field);
        return $methods->getOutput();
    }

    public function getOutput()
    {
        $out = "<?php";
        $out .= $this->getHeader();
        $out .= $this->getConstants();

        foreach ($this->metadata as $value) {
            $out .= $this->getSetterGetter($value);
        }

        $out .= "}\n";
        return $out;
    }

    public function printOut()
    {
        echo $this->getOutput();
    }

}
