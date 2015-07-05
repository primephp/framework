<?php

namespace Prime\Server\Http;

use App\Config\AppConfig;
use Exception;
use Prime\Controller\ErroControl;
use Prime\Server\Http\Interfaces\IHttpRoute;
use Prime\Server\Http\HttpUri;

/**
 * Descrição da Classe Router
 *
 * @author TomSailor
 * @since 03/08/2011
 */
final class Router implements IHttpRoute {

    private $httpUri = NULL;

    /**
     * 
     * /Controller/Action?id=1
     */
    public function __construct($url = NULL) {
        $this->httpUri = HttpUri::getInstance($url);
    }

    private function define($urlString) {
        
    }

    /**
     * Define uma requisição diferente para ser processada
     * @param string $uri
     */
    public function setRequest($uri) {
        $this->httpUri->setUri($uri);
    }

    public function getRequest() {
        return $this->httpUri->getRequest();
    }

    public function getQueryString() {
        return http_build_query($this->params);
    }

    public function addParam($name, $value) {
        $this->params[$name] = $value;
    }

    public function getParam($name) {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        } else {
            return NULL;
        }
    }

    public function module() {
        return $this->url['module'];
    }

    public function controller() {
        if (!is_null($this->httpUri->getUriController())) {
            return ucfirst($this->httpUri->getUriController());
        } else {
            return ucfirst(AppConfig::getDefaultController());
        }
    }

    public function controllerClass() {
        if (AppConfig::getNamespace(ucfirst($this->controller()))) {
            $namedControl = AppConfig::getNamespace(ucfirst($this->httpUri->getUriController()))
                    . '\\' . $this->controller() . 'Control';
        } else {
            $namedControl = 'App\Modules\\'
                    . ucfirst($this->controller())
                    . '\\' . $this->controller() . 'Control';
        }

        return ucfirst($namedControl);
//        exit();
    }

    public function action() {
        if (!is_null($this->httpUri->getUriAction())) {
            $return = $this->httpUri->getUriAction();
        } else {
            $return = AppConfig::getDefaultAction();
        }
        return $return . 'Action';
    }

    /**
     * Executa a rota passada pelo requisição
     * através do call_user_function_array
     */
    public function execute() {
        $controller = $this->controllerClass();
        if (class_exists($controller, true)) { //SE O CONTROLADOR SOLICITADO EXISTE
            //Instancia o objeto controller
            try {
                $obj = new $controller();
            } catch (Exception $exc) {
                trigger_error($exc->getTraceAsString(), E_USER_ERROR);
            }
            //verifica se a action não existe no Controller
            if (!method_exists($obj, $this->action())) {
                trigger_error('Método Action não encontrado : ' . $this->action(), E_USER_WARNING);
                self::send(ErroControl::NAME, ErroControl::ACTION_404);
            } else {
                call_user_func_array(array($obj, $this->action()), $this->httpUri->getUriParameters());
            }
        } else { //SE NÃO FOI DEFINIDO CORRETAMENTE O CONTROLADOR
            //Redireciona para a raiz do site
            trigger_error('Classe Controller não encontrada : ' . $this->controllerClass() . ' - ' . $this->httpUri->getValue(), E_USER_WARNING);
            self::send(ErroControl::NAME, ErroControl::ACTION_404);
        }
    }

    public function debug() {

        if (!empty($this->value)) {
            $this->define($this->value);
        } else {
            $server = new Server();
            $this->define($server->requestUri());
        }
        echo '<pre>';
        var_dump($_SERVER);
        echo $this->getQueryString();
        echo "Controller: " . $this->controller() . "<br>";
        echo "Action: " . $this->action() . "<br>";
        echo "Parametros: <br>";
        print_r($this->httpUri->getUriParameters());
        echo '<pre>';
    }

    /**
     * Método Estático redirect
     * Redireciona para a página definida, podendo ser passado o parâmetro
     * com tempo a ser aguardado antes de redirecionar
     * ATENÇÃO: O método deve ser chamado antes de qualquer coisa ser escrita
     * @param string $url URL a ser usada para o redirecionamento
     * @param int $tempo tempo para ser esperado antes de redirecionar
     */
    public static function redirect($url, $tempo = 0) {
        if ($url instanceof Url) {
            $url = $url->queryString();
        }
        $url = str_replace('&amp;', '&', $url);

        if ($tempo > 0) {
            header("Content-Type: text/html; chatset=UTF-8", false);
            header("Refresh: $tempo; URL=$url");
        } else {
            echo "<script> window.location.href=\"$url\";</script>";
            exit;
        }
    }

    /**
     * Método Estático send
     * Redireciona para a página definida, de acordo com o nome do controller,
     * action e parâmetros passados como parâmetros do método
     * @param string $controller
     * @param string $action
     * @param array $params
     */
    public static function send($controller = null, $action = NULL, $params = array()) {
        $url = new Url($controller, $action, $params);

        $uri = $url->queryString();

        echo "<script>window.location = \"$uri\";</script>";
    }

}
