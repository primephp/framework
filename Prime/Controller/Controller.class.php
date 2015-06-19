<?php

namespace Prime\Controller;

use App\Application,
    App\Modules\Perfil\UsuarioControl,
    Prime\Http\Router,
    Prime\Http\Session,
    Prime\Http\Url,
    Prime\Model\DAO\Connection,
    Prime\Model\DAO\Transaction,
    stdClass;

/**
 * Descrição da Classe Controller<br>
 * 
 * <br>
 * Por Padrão todos os métodos de Ação do Controller
 * deve ser nomeados com o sufixo Action
 * @package Prime\Controller
 * @author TomSailor
 * @since 03/08/2011
 */
abstract class Controller implements IController {

    public function __construct() {
        $this->initialize();
    }

    public function initialize() {
        Application::ConnectDB();
        //$logger = new TLoggerHTML(APP_PATH.'logger.html');
        //Transaction::setLogger($logger);
    }

    public function finalize() {
        if (Connection::get()) {
            Transaction::close();
        }
    }

    /**
     * Verifica se a requisição foi ajax
     * @return type 
     */
    protected function is_ajax() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
    }

    public function __destruct() {
        $this->finalize();
    }

    public function debug() {
        
    }

    public static function Redirect($url, $tempo = 0) {
        if ($url instanceof Url) {
            $url = $url->queryString();
        }
        Router::redirect($url, $tempo);
    }

    /**
     * Método Estático restrict
     * Verifica se está logado, caso contrário
     * redireciona para a página incial do site
     */
    public static function restrict() {
        if (!UsuarioControl::logged()) {
            $session = new Session();
            $session->setValue("msg", array("title" => "ACESSO NEGADO", "text"
                => "Área restrita a usuários cadastrados"));
            Router::redirect("/");
            exit;
        }
    }

    protected function arrayToObj($array) {
        if (is_array($array)) {
            $class = new stdClass();
            foreach ($array as $key => $value) {
                $class->$key = $value;
            }
            return $class;
        } else {
            return false;
        }
    }

    public function mensagem($title, $text) {
        $session = new Session();
        $session->setValue("msg", array("title" => $title, "text" => $text));
    }

    public static function back() {
        echo "<script type=\"text/javascript\">";
        echo "history.back();";
        echo "</script>";
    }

}

