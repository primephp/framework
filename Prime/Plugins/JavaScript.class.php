<?php

namespace Prime\Plugins;

use App\Config\AppConfig,
    Prime\Http\Url;

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

    public static function insertFile($filename, $tags = FALSE) {
        $content = NULL;
        $filename = PUBLIC_PATH . AppConfig::baseScripts() . $filename;
        $filename = str_replace('//', '/', $filename);
        if (file_exists($filename)) {
            $content = file_get_contents($filename);
        } else {
            trigger_error($filename . ' não encontrado');
        }
        if ($tags) {
            $content = '<script>' . $content . '</script>';
        }
        return $content;
    }

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


