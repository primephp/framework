<?php

namespace Prime\Register;

/**
 * O objetivo principal de ParserFileIni � ser usado como
 * um analisador de arquivos padronizados de configura��o arquivo.ini.
 * Esta classe apos faze a an�lise do arquivo ini permite que o usu�rio
 * acesse e altere seu atributos no modelo orientado a objetos com m�todos leitores
 * get ou ler. O acesso tamb�m poder� ser feito diretamente pelo nome da chave
 * no arquivo que se tornar� um atributo(membro) do objeto sen usado.
 * o m�todo leitor poder� ser usado em uma das formas getAtributo() ou lerAtributo()
 * A gera��o do nome do m�todo ser� din�mica em virtude da implementa��o dos m�todos m�gicos
 * __set(), __call() e __get() de PHP.
 * Esta classe recebe um arquivo de configura��o habitual arq.ini como par�metro no construtor contendo
 * uma estrutura definida por se��o e dentro de cada se��o um conjunto de chaves
 * seguido por seu valore. Entre a chave e o valor dever� ter um serparador de igualdade
 * como no exemplo abaixo e n�o poder� haver espacos entre, caso a chave seja composta por dois nomes
 * [secao1]
 * key = v1
 * key2=100
 *
 * [secao2]
 * db_name = foo
 *

 */
class ConfigurationFileParser {

    private $data = array();
    private $filename;

    /**
     * O par�metro $filename deve representar um caminho v�lido de arquivo para
     * que possa ser lido e analisado pelo parser do PHP. Todas as chaves do arquivo devem ser
     * em min�sculas ou o analisador ParserFileIni far� isso pra voc�. Os valores das chaves n�o ser�o
     * alterados.
     *
     * @param string $file
     */
    public function __construct($filename) {
        if (file_exists($filename)) {
            if (is_file($filename) || is_readable($filename)) {
                $this->filename = $filename;
                $this->format($filename);
                //----------------------------------------------------------------
                //tenta por cada chave e nome de secao dentro de um padrao aceitavel
                //equalizando-as para minusculas
                foreach ($this->data as $section => $array) {
                    if (is_array($array)) {
                        $this->data[$section] = array_change_key_case($array, CASE_LOWER);
                    }
                }
                $this->data = array_change_key_case($this->data, CASE_LOWER);
            } else {
                trigger_error("Caminho de arquivo passado como par�metro ('$filename') em " . __CLASS__ . " N�o pode ser acessado.", E_USER_ERROR);
            }
        } else {
            trigger_error("Caminho de arquivo passado como par�metro ('$filename') em " . __CLASS__ . " N�o pode ser localizado.", E_USER_ERROR);
        }
    }

    private function format($filename) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES);
        $secao = "";
        foreach ($lines as $lPos => $line) {

            //---------------------------------------------------
            //Busca um coment�rio iniciado por ; ou #
            $c_pos = FALSE;
            $c_pos = ($c_pos === FALSE) ? strpos(trim($line), ";") : strpos(trim($line), "#");
            if ($c_pos === 0 || !strlen($line)) {
                $this->data[$lPos] = $line;
            } else {
                //---------------------------------------------------
                //Busca por um se��o de configuracao do arquivo ini
                $s_pos = FALSE;
                $s_rpos = FALSE;
                $s_pos = strpos(trim($line), "[");
                $s_rpos = strpos(trim($line), "]");
                if ($s_pos !== FALSE && $s_rpos !== FALSE) {
                    $secao = trim(substr($line, $s_pos + 1, $s_rpos - 1));
                    $this->data[$secao] = array();
                } else {
                    //---------------------------------------------------
                    //armazena cada para chave-valor na sua devida secao
                    if (!empty($secao)) {
                        $v_pos = -1;
                        $v_pos = strpos($line, "=");
                        if ($v_pos > 0) {
                            $arr_ini = explode("=", $line);
                            $this->data[$secao][trim($arr_ini[0])] = trim($arr_ini[1]);
                        }
                    }
                }
            }
        }
    }

    /**
     * M�todo m�gico de PHP. quando definido na classe, sempre que for atribu�do
     * um valor a um atributo nao definido na classe, ela sera chamada automaticamente
     * pelo engine do PHP e se n�o estiver definida o PHP gerar� um erro.
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value) {
        $key = strtolower($key);
        foreach ($this->data as $secName => $section) {
            if (is_array($section) && array_key_exists($key, $section)) {
                $this->data[$secName][$key] = $value;
            }
        }
    }

    /**
     * M�todo m�gico do PHP. Sempre que for chamado um m�todo em um objeto que
     * n�o foi definido na classe, o engine do PHP tentar� localizar este m�todo e se ele (__call) n�o
     * foi definido ent�o retornar� um erro.
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments) {
        if (strpos($name, "get") === FALSE) {
            return "erro";
        }
        $key = strtolower(substr($name, 3));
        foreach ($this->data as $section)
            if (is_array($arguments) && count($arguments) == 1) {
                $key = $arguments[0];
            }
        if (is_array($section) && array_key_exists("$key", $section)) {
            return $section[$key];
        }
    }

    /**
     * M�todo m�gico do PHP. Sempre que se desejar usar atributos n�o definidos
     * n�o classe, isto � adicionado dinamicamente a um objeto, e necessitar ler este
     * atributo, deve definir este m�todo leitor. Caso ele n�o seja definido o PHP, ap�s
     * tentar localizar retornar� um erro.
     * @param string $key
     * @return mixed
     */
    public function __get($key) {
        //um fato interessante sobre este m�todo � que embora se use o
        //a vari�vel de objeto $this durante a atribui��o __set, nao se faz necess�rio
        //durante a leitura, portanto usar $this->$name -� equivalente a vari�vel $name
        foreach ($this->data as $section)
            if (is_array($key)) {
                $key = $key[0];
            }
        if (is_array($section) && array_key_exists($key, $section)) {
            return $section[$key];
        }
        return NULL;
    }

    /**
     * Salva o o texto modificado ap�s alguma configura��o ter alterada.
     * O arquivo dever� ter o mesmo nome do arquivo passado como par�metro no construtor
     * e ser� acrescido a extensao .new
     * O diret�rio onde se encontra o arquivo original dever� ter permiss�o de escrita.

     */
    public function saveChangesToFile() {
        file_put_contents($this->filename . ".new", $this->getConf());
    }

    /**
     * Retorna o texto atual do arquivo de configura��o. Caso seja chamado saveChangesToFile()
     * ser� esta representa��o de texto que ser� salva.
     * @return string
     */
    public function getConfText() {
        $text = "";
        foreach ($this->data as $secKey => $section) {
            if (is_string($section)) {
                $text.="$section\n";
            } else {
                $text .="[$secKey]\n";
                if (is_array($section)) {
                    foreach ($section as $key => $value) {
                        $text .="$key = $value\n";
                    }
                }
            }
        }

        return $text;
    }

}

