<?php

namespace Prime\FileSystem;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;
use UnexpectedValueException;

/**
 * Description of Filesystem
 * @package Prime\FileSystem
 * @createAt 28/07/2015
 * @author TomSailor
 */
class Filesystem extends SymfonyFilesystem {

    /**
     * Armazena uma instância única do objeto Filesystem
     * @var Filesystem
     */
    private static $instance;
    protected static $documentRoot;
    protected static $paths = [];

    /**
     * Construtor privado para impedir múltiplas instância do objeto filesystem
     */
    private function __construct() {
        
    }

    /**
     * Retorna a instância única de FileSystem
     * @return Filesystem
     */
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Filesystem();
        }
        return self::$instance;
    }

    /**
     * Define um diretório raiz para a manipulação de arquivos e diretórios
     * @param string $path
     * @throws FileNotFoundException
     */
    public static function setDocumentRoot($path) {
        $fs = self::getInstance();
        if ($fs->exists($path)) {
            self::$documentRoot = $path;
        } else {
            throw new FileNotFoundException("O diretório $path não existe");
        }
    }

    /**
     * Adiciona um array de {$alias, $path} para serem utilizados na manipulação
     * de arquivos e diretórios
     * @param array $paths
     * @example $array = ['alias1' => 'path1', 'alias2' => 'path2'];
     */
    public static function addPaths(array $paths) {
        $fs = self::getInstance();
        foreach ($paths as $key => $value) {
            $fs->addPath($key, $value);
        }
    }

    /**
     * Adiciona um alias para um path para utilização na manipulação de arquivos 
     * e diretórios
     * @param string $alias Nome do Alias a ser definido
     * @param string $path Caminho do Diretório
     * @throws UnexpectedValueException Caso o alias já esteja em uso
     * @throws FileNotFoundException Caso o diretório definido não exista
     */
    public function addPath($alias, $path) {
        if ($this->exists($path)) {
            if (!key_exists($alias, self::$paths)) {
                self::$paths[$alias] = $path;
            } else {
                throw new UnexpectedValueException("O alias $alias já está em uso em " . __CLASS__ . ".");
            }
        } else {
            throw new FileNotFoundException("O diretório $path não existe");
        }
    }

    /**
     * Retorna o path armazenado internamente para o alias passado como
     * parâmetro
     * @param string $alias
     * @return string
     */
    public function getPath($alias) {
        if (isset(self::$paths[$alias])) {
            return self::$paths[$alias];
        }
    }

    /**
     * Método clone do tipo privado previne a clonagem dessa instância
     * da classe
     *
     * @return void
     */
    private function __clone() {
        
    }

    /**
     * Método unserialize do tipo privado para prevenir a desserialização
     * da instância dessa classe.
     *
     * @return void
     */
    private function __wakeup() {
        
    }

}
