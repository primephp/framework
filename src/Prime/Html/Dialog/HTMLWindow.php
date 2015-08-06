<?php

namespace Prime\Html\Dialog;

use App\Config\AppConfig,
    Prime\Config\IMouseEvent,
    Prime\Html\Base\HTMLDiv,
    Prime\Html\Base\HTMLElement,
    Prime\Html\Base\HTMLImage,
    Prime\Html\Base\HTMLSpan,
    Prime\Html\Interfaces\IHTMLWindow,
    Prime\View\ViewInterface;

/**
 * Descrição de HTMLWindow
 *
 * @author tom
 */
class HTMLWindow implements IHTMLWindow
{

    private static $counter = 0;
    private $window;
    private $windowId;
    private $top;
    private $left;
    private $width;
    private $height;
    private $title;
    private $content;
    private $icon;
    private $titleAlign;
    private $closeIcon;
    private $zIndex;

    public function __construct($title = '', $width = 350, $height = 100)
    {
        $this->content = [];
        $this->title = (string) $title;
        $this->titleAlign = 'left';
        $this->width = intval($width);
        $this->height = intval($height);
        $this->windowId = "HTMLWindow" . self::$counter++ . "_" . date('his');
        self::$counter++;

        $this->closeIcon = new HTMLImage(AppConfig::baseIcons() . "closing.png");
        $this->closeIcon->setAttribute('id', 'closeButton');
        $this->closeIcon->setStyle('cursor', 'pointer');
        $this->closeIcon->setStyle('float', 'right');
        $this->closeIcon->{IMouseEvent::CLICK} = "$('#$this->windowId').fadeOut('slow');";

        $this->window = new HTMLElement('div');
        $this->window->setAttribute('id', $this->windowId);
        $this->window->setAttribute('class', 'ui-widget ui-corner-bottom');
        $this->window->setStyle('position', 'fixed');
        $this->zIndex = self::$counter + 1000;
    }

    public function appendChild($child)
    {
        $this->content[] = $child;
    }

    public function prependChild($child)
    {
        array_unshift($this->content, $child);
    }

    public function zIndex($value)
    {
        $this->zIndex = $value;
    }

    /**
     * Retorna os conteúdos adicionados na Janela 
     */
    private function getContent()
    {
        $content = '';
        foreach ($this->content as $child) {
            if ($child instanceof ViewInterface) {
                $content .= $child->getOutput();
            } else {
                $content .= $child;
            }
        }

        $div = new HTMLDiv('WindowContent');
        $div->setAttribute('class', 'ui-widget-content ui-corner-bottom');
        $div->setStyle('position', 'relative');
        $div->setStyle('padding', '5px');
        //$div->setStyle('width', '100%');
        $div->setStyle('height', '100%');
        $div->setStyle('bottom', 0);
        $div->appendChild($content);

        return $div->getOutput();
    }

    private function getTitle()
    {
        $div = new HTMLDiv('WindowTitle');
        $div->setAttribute('class', 'ui-widget-header');
        $div->setStyle('position', 'relative');
        $div->setStyle('top', 0);
        $div->setStyle('text-align', $this->titleAlign);
        $div->setStyle('padding', '5px');

        $span = new HTMLSpan($this->title);


        $div->appendChild($span);
        $div->appendChild($this->closeIcon);
        $div->setAttribute(IMouseEvent::DOWN, "$('#$this->windowId').draggable();");

        return $div->getOutput();
    }

    public function setAttribute($name, $value)
    {
        $this->window->setAttribute($name, $value);
    }

    public function setPosition($top, $left)
    {
        $this->top = $top;
        $this->left = $left;
    }

    public function setSize($width = 350, $height = 150)
    {
        $this->width = intval($width);
        $this->height = intval($height);
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setTitleAlign($align)
    {
        $this->titleAlign = $align;
    }

    public function setClosingIcon($src)
    {
        $this->closeIcon = new HTMLImage($src);
    }

    public function setTitleIcon($src)
    {
        $this->icon = new HTMLImage($src);
        $this->icon->setMaximumSize(24, 24);
    }

    public function getAttribute($name)
    {
        if (isset($this->{$name})) {
            return $this->{$name};
        }
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getWindowId()
    {
        return $this->windowId;
    }

    public function getOutput()
    {
        $this->window->setStyle('height', $this->getHeight() . 'px');
        $this->window->setStyle('width', $this->getWidth() . 'px');
        $this->window->setStyle('z-index', $this->zIndex);

        if (is_numeric($this->top)) {
            $this->top .= 'px';
        }
        if (is_numeric($this->left)) {
            $this->left .= 'px';
        }
        $this->window->setStyle('top', $this->top);
        $this->window->setStyle('left', $this->left);

        $this->window->appendChild($this->getTitle());
        $this->window->appendChild($this->getContent());

        return $this->window->getOutput();
    }

    public function printOut()
    {
        echo $this->getOutput();
    }

}
