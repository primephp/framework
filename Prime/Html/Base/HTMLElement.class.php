<?php
namespace Prime\Html\Base;

use Prime\Html\Interfaces\IHTMLElement,
    Prime\Html\Style\HTMLStyleInline;

class HTMLElement implements IHTMLElement {

    private $tag_name;
    private $properties;
    private $children = array();
    private $openTag;
    private $midTag;
    private $close_tag;
    private $style;

    /**
     *
     * @param string $name
     */
    public function __construct($name) {
        //define o nome do elemento
        $this->tag_name = $name;
    }

    /**
     * método __set()
     * intercepta as atribuições à propriedades do objeto
     *
     * @param string $name;
     * @param string $value;
     * @return void
     */
    public function __set($name, $value) {
        //armazena os valores atribuidos
        //ao array properties
        $this->properties[$name] = $value;
    }

    /**
     * Intercepta e retorna o valor da propriedade se ela existe
     * @param type $name
     * @return type 
     */
    public function __get($name) {
        if (isset($this->properties[$name])) {
            return $this->properties[$name];
        }
    }

    /**
     * Recupera um valor atribuído ao objeto atual;
     * @param string $name
     * @return mixed 
     */
    public function getAttribute($name) {
        if (isset($this->properties[(string) $name])) {
            return $this->properties[(string) $name];
        } else {
            return FALSE;
        }
    }

    /**
     * Retorna o último elemento filho adicionado 
     * @return mixed
     */
    public function getLastChild() {
        $childNum = count($this->children) - 1;
        if (isset($this->children[$childNum])) {
            return $this->children[$childNum];
        }
    }

    /**
     * Retorna o primeiro elemento filho adicionado
     * @return mixed
     */
    public function getFirstChild() {
        if (isset($this->children[0])) {
            return $this->children[0];
        }
    }

    public function hasChildren() {
        return (bool) count($this->children);
    }

    /**
     * Compatibilizar com o objetos comumente usado que seguem a orietação DOM.
     * Acrescenta ou altera um atributo do objeto atual;
     * @param string $name
     * @param mixed $value 
     */
    public function setAttribute($name, $value) {
        //armazena os valores atribuidos
        //ao array properties
        $this->properties[$name] = $value;
    }

    public function setTitle($title) {
        $this->properties['title'] = $title;
    }

    /**
     * Adciona um elemento filho ou um array de elementos
     *
     * @param mixed $child
     */
    public function appendChild($child) {
        if (is_array($child)) {
            foreach ($child as $childs) {
                $this->children[] = $childs;
            }
        } else {
            $this->children[] = $child;
        }
    }

    public function prependChild($child) {
        array_unshift($this->children, $child);
    }

    /**
     *
     * @return <type>
     */
    private function openTag() {
        $this->openTag = "<{$this->tag_name}";
        $this->midTag = "";
        if (is_array($this->properties)) {
            foreach ($this->properties as $attribute => $value) {
                $this->midTag .= " " . $attribute . "=\"{$value}\"";
            }
        }
        $this->midTag .= " " . $this->getStyles();
        $this->close_tag = (is_array($this->children)) ? ">" : "/>";
        return $this->openTag . $this->midTag . $this->close_tag;
    }

    /**
     * Fecha uma tag HTML
     *
     */
    private function closeTag() {
        return "</{$this->tag_name}>\n";
    }

    /**
     * Método que exibe a tag na tela, juntamente com seu conteúdo
     *
     */
    public function printOut() {
        echo $this->getOutput();
    }

    /**
     * Retorna o HTML na forma de uma string ao invés de escrever na saida de dados
     * pro navegador
     *
     * @return string
     */
    public function getOutput() {
        $content = "";
        $openTag = "";
        $close_tag = "";
        $tag_name = $this->openTag();
        if (is_array($this->children)) {
            foreach ($this->children as $child) {
                if (is_object($child)) {
                    $tag_name .= $child->getOutput();
                } else if (is_string($child) || is_numeric($child)) {
                    //se representa texto imprimiveis na tela
                    $tag_name .= $child;
                }
            }
            $tag_name .= $this->closeTag();
        }
        //conclui o fechamento da marca html
        return $tag_name;
    }

    /**
     * Método setStyle
     * Adiciona propriedades à variável $style
     * para estilização CSS inline da tag HTML
     * @param string $property
     * @param string $value 
     */
    public function setStyle($property, $value) {
        if ($value instanceof HTMLStyleInline) {
            $this->setAttribute('style', $value->getOutput());
        } else {
            $this->style[$property] = $value;
        }
    }

    /**
     * Método getStyles
     * Retorna a formatação inline CSS se há propriedas da variável
     * $style;
     * @return string 
     */
    private function getStyles() {
        if ($this->style) {
            $style = "style = \"";
            foreach ($this->style as $key => $value) {
                $style .= "$key:$value; ";
            }
            $style .= "\"";
            return $style;
        } else {
            return null;
        }
    }

}

?>