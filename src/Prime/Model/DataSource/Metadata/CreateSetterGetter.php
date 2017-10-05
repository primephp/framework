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

namespace Prime\Model\DataSource\Metadata;

/**
 * Classe CreateSetterGetter
 * @name CreateSetterGetter
 * @package Prime\Model\DataSource\Metadata
 * @since 22/07/2015
 * @author devel4
 */
class CreateSetterGetter
{

    private $name;
    private $method;
    private $type;
    private $const;
    private $notNull;

    public function __construct(array $field)
    {
        $this->name = $field['name'];
        $this->type = $field['type'];
        $this->method = $this->getMethod();
        $this->const = 'self::FIELD_' . strtoupper($this->name);
    }

    private function getMethod()
    {
        $uMethodo = ucfirst(strtolower($this->name));
        if (strpos($uMethodo, "_")) {
            $fragments = explode("_", $uMethodo);
            $uMethodo = "";
            foreach ($fragments as $fragment) {
                if (empty($uMethodo)) {
                    $uMethodo = $fragment;
                } else {
                    $uMethodo .= ucfirst($fragment);
                }
            }
        }
        return $uMethodo;
    }

    private function getter()
    {
        $getter = NULL;
        switch ($this->type) {
            case 'string':
                $getter = $this->getterString();
                break;
            case 'int':
                $getter = $this->getterInteger();
                break;
            case 'timestamp':
                $getter = $this->getterInteger();
                break;
            case 'float':
                $getter = $this->getterFloat();
                break;
            case 'datetime':
                $getter = $this->getterDatetime();
                break;
            case 'date':
                $getter = $this->getterDatetime();
                break;
            default:
                $getter = $this->getterDefault();
                break;
        }
        return $getter;
    }

    public function setterDefault($value)
    {
        $this->data[self::FIELD_ID_MENSAGEM] = $value;
    }

    public function getterDefault()
    {
        return "/**
                  * Retorna uma string contendo o valor de {$this->name}
                  * ou NULL   
                  * @return string|NULL
                  */"
                . "\npublic function get{$this->method}(){\n" .
                "if(!empty(\$this->data[{$this->const}])){
            return htmlspecialchars(\$this->data[{$this->const}]);
        }\n"
                . "return NULL;\n"
                . "}\n";
    }

    public function getterString()
    {
        return " /**
                  * Retorna um objeto TStrig contendo o valor de {$this->name}
                  * ou NULL   
                  * @return \Prime\Core\TString|NULL
                  */"
                . "\npublic function get{$this->method}(){\n" .
                "if(!empty(\$this->data[{$this->const}])){
            \$value = htmlspecialchars(\$this->data[{$this->const}]);
        }else{\n"
                . "\$value = '';\n"
                . "}\n"
                . "return new \Prime\Core\TString(\$value);\n"
                . "}\n";
    }

    public function getterInteger()
    {
        return " /**
                  * Retorna um objeto TInteger contendo o valor de {$this->name}
                  * ou NULL   
                  * @return \Prime\Core\TInteger
                  */"
                . "\npublic function get{$this->method}(){\n" .
                "if(!empty(\$this->data[{$this->const}])){
            \$value = \$this->data[{$this->const}];
        }else{\n"
                . "\$value='';\n"
                . "}\n"
                . "return new \Prime\Core\TInteger(\$value);\n"
                . "}\n";
    }

    public function getterDatetime()
    {
        return " /**
                  * Retorna um objeto Datetime contendo o valor de {$this->name}
                  * ou NULL   
                  * @return \Prime\Util\Datetime\Datetime|NULL
                  */"
                . "\npublic function get{$this->method}(){\n" .
                "if(!empty(\$this->data[{$this->const}])){
            \$value = \$this->data[{$this->const}];
                return new \Prime\Util\Datetime\Datetime(\$value); 
        }\n"
                . "return NULL;\n"
                . "}\n";
    }

    public function getterFloat()
    {
        return " /**
                  * Retorna um objeto TFloat contendo o valor de {$this->name}
                  * ou NULL   
                  * @return \Prime\Core\TFloat|NULL
                  */"
                . "\npublic function get{$this->method}(){\n" .
                "if(!empty(\$this->data[{$this->const}])){
            \$value = \$this->data[{$this->const}];
                return new \Prime\Core\TFloat(\$value); 
        }\n"
                . "return NULL;\n"
                . "}\n";
    }

    private function setter()
    {
        $value = strtolower($this->type);
        $body = "";
        if (in_array($this->type, array('int', 'float', 'string'))) {
            $body .= "\n\$this->data[$this->const] = ({$this->type})\$$value;";
        } else {
            $body .= "\n\$this->data[$this->const] = \$$value;";
        }

        $return = " /**
                  * Define o valor para o campo '{$this->name}'
                  * 
                  * @param {$this->type} \$$value O valor a ser definido para o campo '{$this->name}'
                  */"
                . "\npublic function set{$this->method}(\$$value){";
        if ($this->notNull) {
            $return .= "if(!is_null(\$$value)){
                $body
            }";
        } else {
            $return .= $body;
        }
        $return .= "\n}";
        return $return;
    }

    private function setNotNull()
    {
        
    }

    public function getOutput()
    {
        return $this->setter() . "\n" . $this->getter();
    }

    public function printOut()
    {
        echo $this->getOutput();
    }

}
