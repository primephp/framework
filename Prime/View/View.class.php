<?php

namespace Prime\View;

/**
 * Description of View
 * @package Prime\View
 *
 * @author tom
 */
abstract class View implements IView {

    /**
     *
     * @var array 
     */
    protected $content = array();

    protected function addContent($content) {
        $this->content[] = $content;
    }

    public function getOutput() {
        $content = '';
        foreach ($this->content as $value) {
            if ($value instanceof IView) {
                $content .= $value->getOutput();
            } else {
                $content .= $value;
            }
        }
        return $content;
    }

    public function printOut() {
        echo $this->getOutput();
    }

}
