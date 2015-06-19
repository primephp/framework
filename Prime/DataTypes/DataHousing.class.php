<?php

namespace Prime\DataTypes;

/**
 * @package Prime\DataTypes
 * O objetivo principal de DataHousing � ser usado como
 * um repositorio de dados de qualquer tipo. Este tipo de classe
 * poderia ser facilmente substituida pela classe padr�o do
 * PHP stdClass, contudo a classe padr�o de PHP somente pode lidar
 * com atributos e nunca com m�todos embora possa ser estendida
 * sem problemas.
 * Durante a elabora��o desta biblioteca (toolkit) de classes para operar
 * com PHP avancado surgiu a necessidade de facilitar a documentacao
 * do sistema ou mesmo ele se auto documentar.
 * se voc� estiver desenvolvendo com o netbeans 6.7 e superior poder� facilmente
 * documentar e simular metodos inexistentes nesta classe, baseando no em um objeto
 * qualquer.
 *
 * Exemplo:
 * Em um ORM temos uma ArrayList de Objetos Frutas
 * retornado em uma consulta de banco de dados.
 * Durante a geracao das classes de ORM você definiu metodos leitores
 * getNomeCampo(), e um objeto ITransaction populou um ArrayList com objetos
 * DataHousing, ent�o a IDE n�o tem como saber que tipo de objetos estao chegando durante uma iteracao
 * na ArrayList, bastando agora você documentar na IDE que o tipo do dados na cole��o � um objeto
 * do tipo Frutas. E entao IDE fará o autocompletar pra voc� e durante o processamento do objeto
 * o PHP se encarregar� do resto, obedecendo as regras conforme determinada nesta classe.
 */
class DataHousing {

    private $data = array();

    public function __construct() {
        
    }

    /**
     * Método mágico de PHP. quando definido na classe, sempre que for atribuído
     * um valor a um atributo nao definido na classe, ela sera chamada automaticamente
     * pelo engine do PHP e se não estiver definida o PHP gerará um erro.
     * @param string $field
     * @param mixed $value
     */
    public function __set($field, $value) {
        $field = str_replace("_", "", strtolower($field));

        $this->data[$field] = $value;
    }

    /**
     * Método mágico do PHP. Sempre que for chamado um m�todo em um objeto que
     * não foi definido na classe, o engine do PHP tentar� localizar este método e se ele (__call) n�o
     * foi definido então retornará um erro.
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments) {
        if (strpos($name, "get") === false) {
            return "";
        }
        $attrib = strtolower(substr($name, 3));
        if (array_key_exists("$attrib", $this->data)) {
            return $this->data[$attrib];
        }
    }

    /**
     * M�todo m�gico do PHP. Sempre que se desejar usar atributos n�o definidos
     * n�o classe, isto � adicionado dinamicamente a um objeto, e necessitar ler este
     * atributo, deve definir este m�todo leitor. Caso ele n�o seja definido o PHP, ap�s
     * tentar localizar retornar� um erro.
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        //um fato interessante sobre este m�todo � que embora se use o
        //a vari�vel de objeto $this durante a atribui��o __set, nao se faz necess�rio
        //durante a leitura, portanto usar $this->$name -� equivalente a
        // var_dump($this);
        if (array_key_exists("$name", $this->data)) {
            return $this->data[$name];
        }
        trigger_error("Atributo '$name' n�o definido nesta classe.", E_USER_ERROR);
    }

    /**
     * retorna a estrutura interna representando os dados
     * em um array associativo;
     *
     * @return array;
     */
    public function getArrayData() {
        return $this->data;
    }

}


