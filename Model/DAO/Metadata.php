<?php

namespace Prime\Model\DAO;

use Prime\Filters\Sanitize,
    Prime\Html\Base\HTMLElement,
    DOMDocument,
    DOMElement,
    PDO;

/**
 * Description of TMetadata
 * @package Prime\Model\DAO
 * @author TomSailor
 */
class Metadata {

    /**
     * 
     * @var PDO 
     */
    private $conn;

    /**
     * @access private
     * @var [array] com os nomes das tabelas do banco
     */
    private $tables = array();
    private $types;
    private $modelNamespace;
    private $viewNamespace;

    public function __construct($table = NULL) {
        //pega a conexão ativa
        /* @var $conn PDO */
        $this->conn = Connection::get();
        if (is_null($table)) {
            $this->getTables();
        } else {
            $this->addTable($table);
        }

        //DEFINE OS TIPOS
        $this->types = array(
            'varchar' => 'varchar',
            'int' => 'integer',
            'integer' => 'integer',
            'intunsigned' => 'integer',
            'datetime' => 'datetime',
            'date' => 'date',
            'text' => 'text'
        );
    }

    public function addTable($tablename) {
        $this->tables[] = $tablename;
    }

    public function setModelNamespace($name) {
        $this->modelNamespace = $name;
    }

    public function setViewNamespace($name) {
        $this->viewNamespace = $name;
    }

    public function getMetadata($table) {
        $query = "SHOW COLUMNS from $table";

        $conn = $this->conn;
        $result = $conn->query($query)->fetchAll();

        $entity = array();
        $table = strtolower($table);
        $children = new HTMLElement("entity");
        $children->setAttribute("xml:id", $table);
        $children->setAttribute("name", $table);
        $i = 0;
        for ($i = 0; $i < count($result); $i++) {
            $entity['name'] = $result[$i]['field'];
            $entity['type'] = str_replace('unsigned', '', Sanitize::letters($result[$i]['type']));
            $entity['size'] = (int) Sanitize::integer($result[$i]['type']);
            $entity['default'] = $result[$i]['default'];
            $entity['key'] = ($result[$i]['key'] == 'PRI' ? 'YES' : 'NO');
            $entity['null'] = ($result[$i]['null'] == 'NO') ? 'YES' : 'NO';

            $xml_col = new HTMLElement("column");
            $xml_col->setAttribute("field", $entity['name']);
            $xml_col->setAttribute("name", $entity['name']);
            $xml_col->setAttribute("type", $entity['type']);
            $xml_col->setAttribute("notnull", $entity['null']);
            $xml_col->setAttribute("default", "{$entity['default']}");
            $xml_col->setAttribute("length", $entity['size']);
            $xml_col->setAttribute("pk", $entity['key']);
            $children->appendChild($xml_col);
        }
        return $children;
    }

    public function toXML() {
        $header = "<?xml version='1.0' encoding='utf8' ?>";
        $documentRoot = new HTMLElement("entities");
        foreach ($this->tables as $entity) {
            $entity_bf = $entity;
            $children = $this->getMetadata($entity_bf);
            $documentRoot->appendChild($children);
        }

        $dom = new DOMDocument();

        $dom->formatOutput = true;
        $dom->preserveWhiteSpace = false;

        //carrega o HTML
        $dom->loadXML($documentRoot->getOutput());

        // Despeja um documento interno em uma string usando a formatação HTML
        $output = $dom->saveXML();

        return $output;
    }

    public function createModel($path = NULL) {
        $isUtf = "";
        $getters = "";
        $setters = "";
        $body = "";
        $fields = "";
        $begins = "";
        $mntDaoCol = "";
        $mntDaoVal = "";
        $nodesAttr = "";
        //carrega um documento XML pre-existente ou gerado durante
        //a execucao de EntityMetadata
        $domDocument = new DOMDocument();
        $domDocument->validateOnParse = false;
        // echo $this->xmlString;
        $domDocument->loadXML($this->toXML());

        //Pega todoas os elementos Entity
        $objEntities = $domDocument->getElementsByTagName("entity");
        //agora iterando cada Entity para manipulá-los
        foreach ($objEntities as $entity) {
            //define o nome da classe
            $className = strtolower($entity->getAttribute("name"));
            $uCase = ucfirst($className);

            //define o nome da tabela
            $tableName = $className;

            $string = $uCase;
            $num = strlen($string);

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


            if ($entity->hasChildNodes()) {
                //recupera os objetos DomNode filhos das entidades que são
                // as colunas de tabelas de dados
                $colunas = $entity->childNodes;
                /**
                 * @package
                 */
                //começa a pegar o conteúdo para montar a classe
                $class = "<?php
 
                    namespace {$this->modelNamespace};
                \n use Prime\Model\DAO\Model;
                \n/**
                *@name T$uCase
                *@package {$this->modelNamespace}
		*@author TomSailor
		*@create " . date('d/m/Y') . "
                *Objetiva facilitar o desenvolvimento com as IDE padroes de mercado.
		*/\n
                        abstract class T$uCase extends Model{
                    ";
                $setters = "";
                $getters = "";
                $constFields = "";

                //armazena o nome das constantes com o nome dos campos
                $constFields = "const TABLENAME = \"{$tableName}\";\n";

                for ($idx = 0; $idx < $colunas->length; $idx++) {
                    $coluna = $colunas->item($idx);
                    if ($coluna instanceof DOMElement) {

                        $nome = $coluna->getAttribute("name");
                        $type = $coluna->getAttribute("type");
                        $uMethodo = ucfirst(strtolower($nome));
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
                        }//if uMethod
                        // armazena os métodos de definição de valor
                        $constFields .= "const FIELD_" . strtoupper($nome) . " = \"{$nome}\";";

                        if ($coluna->getAttribute('pk') == 'YES') {
                            $pk = $nome;
                            $pkType = ($type == 'int') ? 'SERIAL' : 'MD5';
                            echo $type."<br>";
                        }

                        //se for do tipo data
                        if (in_array($type, array("date"))) {
                            $setters .= "
                                    public function set{$uMethodo}(\$$nome){
                                        if(!empty(\$$nome)){
                                            \$date = new TDatetime(\$$nome);
                                            \$this->data[self::FIELD_" . strtoupper($nome) . "] = \$date->getDateUS();
                                        } else {
                                            \$this->data[self::FIELD_" . strtoupper($nome) . "] = '';
                                        }
                                    }
                                ";

                            $getters .= "
                                    public function get{$uMethodo}(){
                                    if(!empty(\$this->data[self::FIELD_" . strtoupper($nome) . "]) and 
                                        \$this->data[self::FIELD_" . strtoupper($nome) . "] != '0000-00-00'){
                                        \$date = new TDatetime(\$this->data[self::FIELD_" . strtoupper($nome) . "]);
                                        return \$date->getDatePTBR();
                                        } else {
                                        return false;
                                    }
                                    }
                                ";
                        } else // se o DateType for DATETIME
                        if (in_array($type, array("datetime"))) {
                            $setters .= "
                                    public function set{$uMethodo}(\$$nome){
                                        \$date = new TDatetime(\$$nome);
                                        \$this->data[self::FIELD_" . strtoupper($nome) . "] = \$date->getDateTimeUSA();
                                    }
                                ";

                            $getters .= "
                                    public function get{$uMethodo}(){
                                    if(!empty(\$this->data[self::FIELD_" . strtoupper($nome) . "])){
                                        \$date = new TDatetime(\$this->data[self::FIELD_" . strtoupper($nome) . "]);
                                        return \$date->getDateTimeBR();
                                    } else {
                                        return false;
                                    }
                                    }
                                ";
                        } else // se o DateType for NUMERIC, FLOAT, DOUBLE
                        if (in_array($type, array("numeric", "float", "double"))) {
                            $setters .= "
                                    public function set{$uMethodo}(\$$nome){
                                        \$money = new TMoney(\$$nome);
                                        \$this->data[self::FIELD_" . strtoupper($nome) . "] = \$money->moneyToFloat();
                                    }
                                ";

                            $getters .= "
                                    public function get{$uMethodo}(){
                                        \$money = new TMoney(\$this->data[self::FIELD_" . strtoupper($nome) . "]);
                                        return \$money->getMoneyptBR();
                                    }
                                ";
                        } else {

                            $setters .= "
                                public function set{$uMethodo}(\$$nome){
                                    \$this->data[self::FIELD_" . strtoupper($nome) . "] = \${$nome};
                            }
                            ";
                            // armazena os métodos para pegar os valores
                            $getters .= "
                                public function get{$uMethodo}(){
                                    if(!empty(\$this->data[self::FIELD_" . strtoupper($nome) . "])){
                                        return htmlspecialchars(\$this->data[self::FIELD_" . strtoupper($nome) . "]);
                                    } else {
                                        return false;
                                    }
                                }
                            ";
                        }
                    }//END instanceof DOMElement
                }//END FOR
                $constFields .= "const PRIMARY_KEY = '$pk';";
                $constFields .= "const KEY_TYPE = '$pkType';";
                $class .= $constFields;
                $class .= $setters;
                $class .= $getters;
                $class .= "}\n";
                echo $class;
                if (file_put_contents($path . 'T' . $uCase . ".class.php", $class)) {
                    echo $class;
                } else {
                    echo "Falha ao criar $uCase \n<br>";
                }
            }//END Se existe nodo filho
        }
    }

    public function createView($path = NULL) {
        //carrega um documento XML pre-existente ou gerado durante
        //a execucao de EntityMetadata
        $domDocument = new DOMDocument();
        $domDocument->validateOnParse = FALSE;

        $domDocument->loadXML($this->toXML());

        $objEntities = $domDocument->getElementsByTagName("entity");
        foreach ($objEntities as $entity) {
            $const = "";
            $size = "";
            $uCase = ucfirst(strtolower($entity->getAttribute("name")));
            $ent_lconst = md5(uniqid('fld'));
            //montando o nome da classe
            if (strpos($uCase, "_")) {
                $fragments = explode("_", $uCase);
                $uCase = "";
                foreach ($fragments as $fragment) {
                    $uCase .= ucfirst($fragment);
                }
            }

            $string = $uCase;
            $num = strlen($string);

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

            if ($entity->hasChildNodes()) {
                //recupera os objetos DomNode filhos das entidades que s�o
                // as colunas de tabelas de dados
                $colunas = $entity->childNodes;
                for ($idx = 0; $idx < $colunas->length; $idx++) {
                    $coluna = $colunas->item($idx);
                    if ($coluna instanceof DOMElement) {
                        $const .="const INPUT_" . strtoupper($coluna->getAttribute("name")) . "=\"frm" . uniqid() . "\";\n";
                        if ($coluna->getAttribute("length") <> 0) {
                            $size .= "const SIZE_" . strtoupper($coluna->getAttribute("name")) . " = " . $coluna->getAttribute("length") . ";\n";
                        }
                    }
                }
                $iface_name = "{$uCase}View";
                $iface = "
		\n/**
		*@author TomSailor
		*@create " . date('d/m/Y') . "
                *Objetiva facilitar o desenvolvimento com as IDE padroes de mercado.
		*/
		interface I$iface_name{
                 $const
                 $size
                 } \n";
            }
            echo "<pre>";

            if ($path) {
                if (file_put_contents("{$path}I{$iface_name}.class.php", "<?php \n"
                                . "namespace {$this->viewNamespace};"
                                . "$iface")) {
                    echo "$iface";
                } else {
                    echo "Falha ao criar $iface_name\n<br/>";
                }
            }
        }
    }

    public function getTables() {
        $conn = $this->conn;

        $query = "SHOW TABLES";

        $statement = $conn->query($query);

        $result = $statement->fetchAll(PDO::FETCH_NUM);

        foreach ($result as $value) {
            $this->tables[] = $value[0];
        }
    }

}
