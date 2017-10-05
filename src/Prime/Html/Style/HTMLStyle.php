<?php

namespace Prime\Html\Style;

class HTMLStyle
{

    private $name;
    private $properties;
    static private $loaded;

    public function __construct($name)
    {
        $this->name = $name;
        self::$loaded[$this->name] = "";
    }

    public function __set($attribute, $value)
    {
        //substitui o "_" por "-" no nome da propriedade;
        $attribute = str_replace('_', '-', $attribute);

        //guarda os valores atribuidos ao array properties
        $this->properties["{$attribute}"] = $value;
    }

    /**
     * Exibe a tag na tela
     *
     */
    public function getOutput()
    {
        if (!self::$loaded[$this->name]) {
            $stl = "<style type='text/css' media='screen'> \n";
            //exibe a abertura do estilo
            $stl .= ".{$this->name}\n";
            $stl .= "{\n";
            if (is_array($this->properties)) {
                //percorre as propriedades
                foreach ($this->properties as $attribute => $value) {
                    $stl .= "\t{$attribute}:{$value};\n";
                }
            }
            $stl .= "}\n";
            $stl .= "</style>\n";
            self::$loaded[$this->name] = true;
            return $stl;
        }
    }

    public function printOut()
    {
        echo $this->getOutput();
    }

    public function getClass()
    {
        return $this->name;
    }

}
