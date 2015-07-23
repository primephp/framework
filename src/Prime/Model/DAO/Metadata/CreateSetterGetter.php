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

namespace Prime\Model\DAO\Metadata;

/**
 * Classe CreateSetterGetter
 * @name CreateSetterGetter
 * @package Prime\Model\DAO\Metadata
 * @since 22/07/2015
 * @author devel4
 */
class CreateSetterGetter {

    private $name;
    private $method;
    private $type;
    private $const;
    private $notNull;

    public function __construct(array $field) {
        $this->name = $field['name'];
        $this->type = $field['type'];
        $this->method = $this->getMethod();
        $this->const = 'self::FIELD_' . strtoupper($this->name);
    }

    private function getMethod() {
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

    private function getter() {
        return "\npublic function get{$this->method}(){\n" .
                "if(!empty(\$this->data[{$this->const}])){
            return htmlspecialchars(\$this->data[{$this->const}]);
        }\n"
                . "return NULL;\n"
                . "}\n";
    }

    private function setter() {
        $value = strtolower($this->type);
        $return = "public function set{$this->method}(\$$value){";
        if ($this->notNull) {
            $return .= "if(!is_null(\$$value)){
                \$this->data[$this->const] = \$$value;
            }";
        } else {
            $return .= "\$this->data[$this->const] = \$$value;";
        }
        $return .= "\n}";
        return $return;
    }

    private function setNotNull() {
        
    }

    public function getOutput() {
        return $this->setter() . "\n" . $this->getter();
    }

    public function printOut() {
        echo $this->getOutput();
    }

}
