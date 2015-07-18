<?php

namespace Prime\Server\Http;

use Prime\Core\Error;
use Prime\Pattern\Singleton\ISingleton;
    

/**
 * Descrição de RequestFile
 * @name RequestFile
 * @package Prime\Server\Http
 * @version 1.0
 * @create 21/06/2012
 * @access public
 * @author tom
 */
class RequestFile implements ISingleton {

    private static $_instance = NULL;
    private $_vars;
    private $errorsType = array();
    private $allowed = array('pdf', 'mpg', 'avi', 'flv', 'mp4', '3gp');
    private $maxsize = 6;
    private $fileName;
    private $mime_types = array();
    private $newName = NULL;
    private $path = NULL;
    private $mimeType = NULL;

    /**
     *
     * @var Error 
     */
    private $objError;

    private function __construct($inputFileName = NULL) {
        $this->fileName = $inputFileName;
        $this->defineMimeTypes();
        if ($_FILES) {
            foreach ($_FILES as $key => $value) {
                $this->_vars[$key] = $value;
            }
        }

        $this->objError = new Error();
        $this->maxsize = 1024 * 1024 * $this->maxsize;

        $this->errorsType[0] = FALSE;
        $this->errorsType[1] = 'O arquivo no upload é maior do que o limite do Servidor';
        $this->errorsType[2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
        $this->errorsType[3] = 'O upload do arquivo foi feito parcialmente';
        $this->errorsType[4] = 'Não foi feito o upload do arquivo';

        if (!is_null($inputFileName)) {
            $this->init();
        }
    }

    /**
     * Faz as verificações iniciais caso seja passado o nome do input do qual
     * se quer processar a requisição
     */
    private function init() {
        if ($this->getError()) {
            $this->addError($this->getError());
        } else {
            $this->defineMime();
        }
    }

    /**
     * Fas as verificações finais antes do processamento da requisição
     */
    private function finalize() {
        if (!$this->checkSize()) {
            $this->addError('Tamanho do arquivo maior que o permitido');
        }
        if(!$this->checkAllowed()){
            $this->addError('Extensão de arquivo não permitida');
        }
    }

    private function defineMime() {
        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
        $mime = finfo_file($finfo, $this->getTmpName());
        finfo_close($finfo);
        if ($this->getTmpName()) {
            $this->mimeType = $mime;
        }
    }

    /**
     * Retorna a instância ativo do objeto RequestFile, caso não haja, inicia e
     * retorna uma instância do objeto
     * @param string $inputFileName
     * @return RequestFile
     */
    public static function getInstance($inputFileName = NULL) {
        if (is_null(self::$_instance)) {
            self::$_instance = new RequestFile($inputFileName);
        }
        self::$_instance->newName = md5(uniqid());
        return self::$_instance;
    }

    /**
     * Define o nome do input a ser capiturado pelo objeto RequestFile
     * Podendo ser utilizado o mesmo objeto para capturar diversos arquivos 
     * requisitados
     * @param str $input
     */
    public function setInputFilename($input) {
        $this->fileName = $input;
    }

    /**
     * Retorna caso houve sucesso no upload o tamanho do arquivo carregado
     * @return int|boolean
     */
    public function getSize() {
        if (isset($this->_vars[$this->fileName]['size'])) {
            return $this->_vars[$this->fileName]['size'];
        } else {
            return FALSE;
        }
    }

    /**
     * Define o tamanho máximo permitido em MB (megaBytes)
     * @param int $value 
     */
    public function setMaxSize($value) {
        $this->maxsize = 1024 * 1024 * (int) $value;
    }

    /**
     * Verifica se o tamanho do arquivo é menor que o permitido <br/>
     * Retornando <b>TRUE</b> caso seja menor e <b>FALSE</b> se for maior
     * @param string $inputFileName
     * @return boolean 
     */
    public function checkSize() {
//        echo "Tamanho: {$this->getSize()} e Valor permitido: {$this->maxsize}";
//        exit();
        if ($this->getSize() > $this->maxsize) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Define um array de extensões permitidas
     * @param array $extensions
     */
    public function setExtensions(array $extensions) {
        $this->allowed = $extensions;
    }

    /**
     * Retorna TRUE se a extensão do arquivo é permitida e FALSE caso não seja
     * permitida
     * @return boolean
     */
    public function checkAllowed() {
        if (in_array($this->getExtension(), $this->allowed)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Retorna o nome do arquivo carregado ou FALSE caso haja falha
     * @return str|boolean
     */
    public function getName() {
        if (isset($this->_vars[$this->fileName]['name'])) {
            return $this->_vars[$this->fileName]['name'];
        } else {
            return FALSE;
        }
    }

    /**
     * Retorna o nome que o arquivo foi armazenado sem sua extensão
     * @return string
     */
    public function getNewNameBody() {
        return $this->newName;
    }

    /**
     * Retorna o nome que o arquivo foi armazenado com sua extensão
     * @return str
     */
    public function getNewName() {
        return $this->newName . '.' . $this->getExtension();
    }

    /**
     * Retorna o mimetype do arquivo carregado ou FALSE caso houve
     * falha no upload
     * @return string|boolean
     */
    public function getMimeType() {
        return $this->mimeType;
    }

    /**
     * Retorna o nome temporário do arquivo carregado ou 
     * FALSE caso houve falha no upload
     * @return string|boolean
     */
    public function getTmpName() {
        if (isset($this->_vars[$this->fileName]['tmp_name'])) {
            return $this->_vars[$this->fileName]['tmp_name'];
        } else {
            return FALSE;
        }
    }

    /**
     * Adiciona mensagens de erros
     * @param string $erroMessage
     */
    private function addError($erroMessage) {
        $this->objError->add($erroMessage);
    }

    /**
     * Retorna o total de errors
     * @return int
     */
    public function hasError() {
        return $this->objError->count();
    }

    /**
     * Retorna um texto que define o tipo de erro de carregamento do arquivo
     * ou FALSE caso hão haja erro no carregamento
     * @return string|FALSE
     */
    public function getError() {
        if (isset($this->_vars[$this->fileName]['error'])) {
            return $this->errorsType[$this->_vars[$this->fileName]['error']];
        } else {
            return FALSE;
        }
    }
    
    /**
     * Retorna um array contendo os erros ocorridos no processamento
     * @return array
     */
    public function getErrors(){
        return $this->objError->getErrors();
    }

    /**
     * Move o arquivo para destino passado como parâmetro
     * @param path $destination
     * @return boolean 
     */
    public function moveFile($destination) {
        $this->finalize();
        if ($this->objError->count()) {
            return FALSE;
        }
        if (move_uploaded_file($this->getTmpName($this->fileName), $destination . DS . $this->newName . '.' . $this->getExtension())) {
            return TRUE;
        } else {
            $this->addError('Erro ao processar o arquivo');
            return FALSE;
        }
    }

    /**
     * Retorna a extensão do arquivo carregado
     * @return string
     */
    public function getExtension() {
        return array_search($this->getMimeType(), $this->mime_types);
    }

    /**
     * Define o nome que o arquivo deve ser armazenado
     * @param string $newFilename
     */
    public function setNewFilename($newFilename) {
        $this->newName = $newFilename;
    }

    /**
     * Copia o arquivo para o diretório passado como parâmetro
     * @param str $path O diretório destino para armazenamento
     * @return boolean
     */
    public function process($path) {
        $this->setPath($path);
        if (!$this->objError->hasError()) {
            return $this->moveFile($this->getPath());
        } else {
            return FALSE;
        }
    }

    /**
     * Define o caminho que deve ser armazenado o arquivo
     * @param str $path
     */
    private function setPath($path) {
        $path = trim($path, DS);
        $this->path = DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR;
    }

    /**
     * Retorna uma str contendo o nome do arquivo, contendo seu caminho e extensão
     * /PATH/TO/FILE/NOME.EXT
     * @return str
     */
    public function getFilePath() {
        return $this->getPath() . $this->getNewName();
    }

    /**
     * Retorna o caminho que o arquivo foi processado.
     * Só estando disponível após o arquivo ser processado.
     * @return str
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Retorna todos os Parâmetros no formato de
     * um array 
     * @return array 
     */
    public function getVariables() {
        return $this->_vars;
    }

    /**
     * Define o MimeTypes aceitos no objetos
     */
    private function defineMimeTypes() {
        $this->mime_types = array(
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpe' => 'image/jpeg',
            'gif' => 'image/gif',
            'png' => 'image/png',
            'bmp' => 'image/bmp',
            'tiff' => 'image/tiff',
            'flv' => 'video/x-flv',
            'mp4' => 'video/mp4',
            '3gp' => 'video/3gpp',
            'avi' => 'video/msvideo',
            'avi' => 'video/x-msvideo',
            'wmv' => 'video/x-ms-wmv',
            'mov' => 'video/quicktime',
            'css' => 'text/css',
            'js' => 'application/x-javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'doc' => 'application/msword',
            'docx' => 'application/msword',
            'xls' => 'application/vnd.ms-excel',
            'xlt' => 'application/vnd.ms-excel',
            'xlm' => 'application/vnd.ms-excel',
            'xld' => 'application/vnd.ms-excel',
            'xla' => 'application/vnd.ms-excel',
            'xlc' => 'application/vnd.ms-excel',
            'xlw' => 'application/vnd.ms-excel',
            'xll' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pps' => 'application/vnd.ms-powerpoint',
            'rtf' => 'application/rtf',
            'pdf' => 'application/pdf',
            'html' => 'text/html',
            'htm' => 'text/html',
            'php' => 'text/html',
            'txt' => 'text/plain',
            'mpeg' => 'video/mpeg',
            'mpg' => 'video/mpeg',
            'mpe' => 'video/mpeg',
            'mp3' => 'audio/mpeg3',
            'wav' => 'audio/wav',
            'aiff' => 'audio/aiff',
            'aif' => 'audio/aiff',
            'zip' => 'application/zip',
            'tar' => 'application/x-tar',
            'swf' => 'application/x-shockwave-flash',
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ott' => 'application/vnd.oasis.opendocument.text-template',
            'oth' => 'application/vnd.oasis.opendocument.text-web',
            'odm' => 'application/vnd.oasis.opendocument.text-master',
            'odg' => 'application/vnd.oasis.opendocument.graphics',
            'otg' => 'application/vnd.oasis.opendocument.graphics-template',
            'odp' => 'application/vnd.oasis.opendocument.presentation',
            'otp' => 'application/vnd.oasis.opendocument.presentation-template',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
            'ots' => 'application/vnd.oasis.opendocument.spreadsheet-template',
            'odc' => 'application/vnd.oasis.opendocument.chart',
            'odf' => 'application/vnd.oasis.opendocument.formula',
            'odb' => 'application/vnd.oasis.opendocument.database',
            'odi' => 'application/vnd.oasis.opendocument.image',
            'oxt' => 'application/vnd.openofficeorg.extension',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
            'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
            'dotm' => 'application/vnd.ms-word.template.macroEnabled.12',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
            'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
            'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
            'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
            'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
            'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
            'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
            'potm' => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
            'ppam' => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
            'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
            'sldm' => 'application/vnd.ms-powerpoint.slide.macroEnabled.12',
            'thmx' => 'application/vnd.ms-officetheme',
            'onetoc' => 'application/onenote',
            'onetoc2' => 'application/onenote',
            'onetmp' => 'application/onenote',
            'onepkg' => 'application/onenote',
        );
    }

}
