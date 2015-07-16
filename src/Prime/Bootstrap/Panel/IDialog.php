<?php

namespace Prime\Bootstrap\Panel;

/**
 * Descrição de IDialog
 * @name IDialog
 * @package Prime\Bootstrap\Panel
 * @version 1.0
 * @create 03/04/2014
 * @access public
 * @author TomSailor <www.eltonluiz@hotmail.com>
 */
interface IDialog {

    /**
     * Define o Estilo para o Panel, aceitando os seguites valores:<br/>
     * PRIMARY, SUCCESS, INFO, WARNING, DANGER
     * @param string $style
     */
    public function setStyle($style);

    public function setTitle($title);

    public function setMessage($message);

    public function setModal($modal = TRUE);

    public function setIdPanel($id);

    public function addButton($button);

    public function getOutput();
    
    public function printOut();
}
