<?php

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Prime\Core\Exceptions\CompileErrorException;
use Prime\Core\Exceptions\CoreErrorException;
use Prime\Core\Exceptions\CoreWarningException;
use Prime\Core\Exceptions\DeprecatedException;
use Prime\Core\Exceptions\NoticeException;
use Prime\Core\Exceptions\ParseException;
use Prime\Core\Exceptions\RecoverableErrorException;
use Prime\Core\Exceptions\StrictException;
use Prime\Core\Exceptions\UserDeprecatedException;
use Prime\Core\Exceptions\UserErrorException;
use Prime\Core\Exceptions\UserNoticeException;
use Prime\Core\Exceptions\UserWarningException;
use Prime\Core\Exceptions\WarningException;
use Prime\FileSystem\Filesystem;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * Executa um dump do valor passado e finaliza 
 * o fluxo da aplicação
 * @param type $value
 */
function dd($value) {
    var_dump($value);
    die();
}

function dump($value) {
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

function primeErrorHandler($err_severity, $err_msg, $err_file, $err_line) {
    switch ($err_severity) {
        case E_WARNING: throw new WarningException($err_msg, Logger::WARNING, $err_severity, $err_file, $err_line);
        case E_PARSE: throw new ParseException($err_msg, Logger::ERROR, $err_severity, $err_file, $err_line);
        case E_NOTICE: throw new NoticeException($err_msg, Logger::NOTICE, $err_severity, $err_file, $err_line);
        case E_CORE_ERROR: throw new CoreErrorException($err_msg, Logger::ERROR, $err_severity, $err_file, $err_line);
        case E_CORE_WARNING: throw new CoreWarningException($err_msg, Logger::WARNING, $err_severity, $err_file, $err_line);
        case E_COMPILE_ERROR: throw new CompileErrorException($err_msg, Logger::ERROR, $err_severity, $err_file, $err_line);
        case E_COMPILE_WARNING: throw new CoreWarningException($err_msg, Logger::WARNING, $err_severity, $err_file, $err_line);
        case E_USER_ERROR: throw new UserErrorException($err_msg, Logger::ERROR, $err_severity, $err_file, $err_line);
        case E_USER_WARNING: throw new UserWarningException($err_msg, Logger::WARNING, $err_severity, $err_file, $err_line);
        case E_USER_NOTICE: throw new UserNoticeException($err_msg, Logger::NOTICE, $err_severity, $err_file, $err_line);
        case E_STRICT: throw new StrictException($err_msg, Logger::WARNING, $err_severity, $err_file, $err_line);
        case E_RECOVERABLE_ERROR: throw new RecoverableErrorException($err_msg, Logger::ERROR, $err_severity, $err_file, $err_line);
        case E_DEPRECATED: throw new DeprecatedException($err_msg, Logger::ALERT, $err_severity, $err_file, $err_line);
        case E_USER_DEPRECATED: throw new UserDeprecatedException($err_msg, Logger::ALERT, $err_severity, $err_file, $err_line);
        default: throw new ErrorException($err_msg, Logger::ERROR, $err_severity, $err_file, $err_line);
    }
}

function primeExceptionHandler(Exception $exc) {
    $logger = new Logger('app_runtime');
    $logger->pushHandler(new RotatingFileHandler(Filesystem::getInstance()->getPath('log') . '/app.log'));
    $code = $exc->getCode();
    if ($code == 0) {
        $code = Logger::ALERT;
    }
    $logger->log($code, $exc->getMessage());
}
