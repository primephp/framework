<?php

namespace Prime\Plugins;

use App\Config\AppConfig,
    Prime\Server\Http\Url;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descrição de JavaScript
 * @package Prime\Plugins
 * Contém métodos estáticos funcionais para JavaScript
 * @author TomSailor
 * @since 31/12/2011
 */
class JavaScript {

    /**
     * Recarregar a página
     * Se o parâmetro for definido como TRUE, recarregado do servidor, do contrário
     * do próprio cache do navegador
     * @param boolean $server
     * @return type 
     */
    public static function reload($server = FALSE) {
        if ($server) {
            return "window.location.reload($server);";
        } else {
            return '$.reload();';
        }
    }

    /**
     * Abre uma nova URL através do endereço passado
     * @param Url $url
     * @return javascript 
     */
    public static function location($url) {
        if ($url instanceof Url) {
            $url = $url->queryString();
        }
        return "window.location='$url'";
    }

    /**
     * Retorna um site atrás através do histórico do navegador
     * @return string 
     */
    public static function back() {
        return 'javascript:history.back();';
    }

    /**
     * Carrega a URL através de ajax
     * @param type $url
     * @return type 
     */
    public static function load($url) {
        if ($url instanceof Url) {
            $url = $url->queryString();
        }
        return "$.jLoader('{$url}')";
    }

    /**
     * Ler e retorna o conteúdo de um arquivo (js)
     * @param string $filename path do arquivo a ser carrego
     * @param boolean $tags Se TRUE retorna o conteúdo entre tag <script>
     * @return string
     */
    public static function insertFile($filename, $tags = FALSE) {
        $content = NULL;
        $filename = str_replace('//', '/', PUBLIC_PATH . AppConfig::baseScripts() . $filename);
        if (file_exists($filename)) {
            $content = file_get_contents($filename);
        } else {
            trigger_error($filename . ' não encontrado');
            return NULL;
        }
        if ($tags) {
            $content = '<script>' . $content . '</script>';
        }
        return $content;
    }

    /**
     * Retorna  um alert() javascript que será impresso na tela do usuário
     * @example  "<script>alert('$mensagem');</script>";
     * @param string $mensagem
     * @return string
     */
    public static function alert($mensagem) {
        return "<script>alert('$mensagem');</script>";
    }

    /**
     * Insere script Javascript entre tags script
     * @param type $script
     * @return type 
     */
    public static function insertScript($script) {
        return '<script>' . $script . '</script>';
    }

}


