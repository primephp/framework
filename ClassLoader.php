<?php

namespace Prime;

if (!defined('PRIVATE_PATH')) {
    $value = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR;
    define('PRIVATE_PATH', $value);
}

/**
 * Descrição de ClassLoader
 * @name ClassLoader
 * @create 09/08/2014
 * @access public
 * @author Tom Sailor <contato@eltonluiz.com.br>
 */
final class ClassLoader {

    /**
     * Armazena, através de recursão na estrutura de diretórios os nomes de pacotes existentes.
     *
     * @var string path
     * @access private
     * @static
     */
    private static $path = "";
    private static $drowned = NULL;

    /**
     * Espera receber um diretório base onde itera recursivamente em busca de
     * pacotes com classes que podem ser entao carregadas dinamicamentes através
     * da função mágica do PHP __autoload.
     * Todas as classes devem estar em arquivos com o mesmo nome seguido do prefixo .class
     * e da extensao .php para o perfeito carregamento.
     *
     * @param string $path
     * @return string
     */
    public static function getIncludePath($path = null) {
        $include_path = get_include_path();
        if (self::$drowned === NULL) {
            $dirSep = DIRECTORY_SEPARATOR;
            if (is_null($path) || empty($path)) {
                $path = dirname(__FILE__);
            } else {
                $path = dirname("$path") . $dirSep . basename("$path");
            }
            $found_path = self::doRecursive($path . $dirSep);
            $include_path .= self::$path;
        }
        set_include_path($include_path);
        return "$include_path";
    }

    /**
     * Entra recursivamente nos diretórios encontrados a fim de possiblitar que a biblioteca tenha
     * a possibilidade de usar pacotes aninhados.
     */
    private static function doRecursive($r) {
        $notLoad = array('.', '..', '.svn', '.subversion');
        if (is_readable($r) && is_dir($r)) {
            $dir = dir($r);
            self::$path.= PATH_SEPARATOR . $dir->path;
            while (false !== ($entry = $dir->read())) {
                if (in_array($entry, $notLoad)) {
                    continue;
                }
                $entry = $dir->path . $entry;
                if (is_dir($entry)) {
                    $entry = $entry . DIRECTORY_SEPARATOR;
                    self::doRecursive($entry);
                }
            }
            $dir->close();
            return true;
        } else {
            echo "Diretório procurado para carregamento da biblioteca não tem permissão de leitura.";
        }
        return false;
    }

    public static function namespaceLoad($class) {
        $className = PRIVATE_PATH . str_replace("\\", '/', $class) . '.class.php';
        if (file_exists($className)) {
            include_once $className;
        }
    }

    public static function namespaced($class) {
        $className = PRIVATE_PATH . str_replace("\\", '/', $class) . '.php';
        if (file_exists($className)) {
            include_once $className;
//            trigger_error('carregando ' . $class . ' com ' . __METHOD__);
        }
    }

}
