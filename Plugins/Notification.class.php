<?php

namespace Prime\Plugins;

/**
 * Descrição da Classe Notification
 * Classe PHP para utilização do Plugin JQuery Notification
 * @name Notification
 * @package Prime\Plugins
 * @subpackage ShowNotification
 * @version 1.0
 * @author tom
 * @since 11/11/2011
 * @access public
 */
class Notification {

    const TYPE_ERROR = 'error';
    const TYPE_INFORMATION = 'information';
    const TYPE_WARNING = 'warning';
    const TYPE_SUCCESS = 'success';

    private $type = 'information';
    private $message = NULL;
    private $duration = 5;
    private $close = 'false';

    public function __construct($message) {
        $this->message = $message;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getOutput() {
        $return = "<div><script type=\"text/javascript\">
                        showNotification({
                            message: \"{$this->message}\",
                            type: \"{$this->type}\",
                            autoClose: {$this->close},
                            duration: {$this->duration}
                        });
                    </script></div>";

        return $return;
    }

    public function autoClose($duration) {
        $this->duration = $duration;
        $this->close = 'true';
    }

    public function printOut() {
        echo $this->getOutput();
    }

}


