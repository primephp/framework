<?php

namespace Prime\Html\Interfaces;

/**
 * Descrição da Interface IHTMLWindow
 * @author Elton Luiz
 */
interface IHTMLWindow extends IHTMLElement
{

    public function setPosition($top, $left);

    /**
     * Define a altura e a largura da janela na tela
     *
     * @param integer $width
     * @param integer $height
     */
    public function setSize($width = 350, $height = 150);

    /**
     * Define a largura definida para a janela
     * @return type 
     */
    public function getWidth();

    /**
     * Retorna a altura DEFINIDA para a janela
     * @return type 
     */
    public function getHeight();

    public function getWindowId();

    /**
     * Indicar um caminho relativo ou absoluto de onde está armazendo
     * o icone para ser usado no indicador de aplicação no canto esquerdo da janela
     * flutuante
     * @param string $src
     */
    public function setTitleIcon($src);

    /**
     * Indicar um caminho relativo ou absoluto de onde est� armazendo
     * o icone para ser usado como botao de fechamento da janela
     * @param string $src
     */
    public function setClosingIcon($src);

    /**
     * Configura o alinhamento do titulo na janela flutuante.
     * Estes valores devem ser os mesmo usado como valores de atributos
     * CSS.
     *
     * @param string $align
     */
    public function setTitleAlign($align);

    /**
     * Alterar o titulo apresentado por uma janela flutuante
     *
     * @param string $title
     */
    public function setTitle($title);
}
