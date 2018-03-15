<?php

namespace Prime\Html\Page;

/**
 * Descri��o de Index
 * Cria e manipula todos os elementos de uma p�gina HTML Index
 * @author Elton Luiz
 */
class Index extends HTMLPage
{

    private $container;
    private $leftContent;
    private $content;
    private $topHeader;
    private $leftMenu;
    private $topMenu;
    private $topLeftMenu;
    private $topRightMenu;
    private $mainContainer;
    private $topContent;
    private $mainContent;

    public function __construct()
    {
        //cria a p�gina e define o t�tulo
        parent::__construct(IConfig::INDEX_TITLE);
        //define os Metadados do HEAD
        $this->setCharset(IConfig::CHARSET);
        $this->setOwner(IConfig::OWNER);
        $this->setSubject(IConfig::SUBJECT);
        $this->setRating();
        $this->setDescription(IConfig::DESCRIPTION);
        $this->setAbstract(IConfig::ABSTRACT_DESCRIPTION);
        $this->setKeywords(IConfig::KEYWORDS);
        $this->setRevisitAfter(5);
        $this->setLanguage(IConfig::LANGUAGE);
        $this->setRobots();
        $this->setPragma();

        //define o arquivo de Estilos em Cascata
        $this->addStyleLink("default.css");
        $this->addStyleLink("jquery/jquery.css");

        //define os arquivos de Scripts
        $this->addScriptLink("jquery.min.js");
        $this->addScriptLink("jquery-ui.min.js");
    }

    private function barraSuperior()
    {
        $barTop = new HTMLDiv("barra_superior");
        $barTop->class = "barra_superior";
        $this->body->appendChild($barTop);
        return $barTop;
    }

    private function container()
    {
        $container = new HTMLDiv("container");
        $container->class = "container";
        $this->container = $container;
        $this->body->appendChild($container);
        return $container;
    }

    private function leftContent()
    {
        $leftMenu = $this->leftMenu();
        $content = new HTMLDiv("leftContent");
        $img = new HTMLImage(Config::baseImages() . "logoCKcom.png");
        $img->width = "180";
        $img->height = "20";
        $content->appendChild($img);
        $content->appendChild($leftMenu);
        $this->leftContent = $content;
        $this->container->appendChild($this->leftContent);
        return $content;
    }

    private function leftMenu()
    {
        $div = new HTMLDiv("leftMenu");

        $ul = new HTMLElement("ul");

        if (is_array($this->leftMenu)) {
            foreach ($this->leftMenu as $item) {
                $li = new HTMLElement("li");
                $li->appendChild($item);
                $ul->appendChild($li);
            }
        }

        $div->appendChild($ul);

        $this->leftMenu = $div;

        return $div;
    }

    private function topHeader()
    {
        $div = new HTMLDiv("topHeader");
        $div->class = "clear paddtop";

        $menu = $this->topMenu();
        $topContent = $this->topContent();

        $borda = new BordaBox();
        $borda->appendChild($menu);
        $borda->appendChild($topContent);

        $clear = new HTMLDiv("clear");

        $div->appendChild([$borda, $clear]);

        $this->topHeader = $div;

        $this->container->appendChild($this->topHeader);

        return $this->topHeader;
    }

    private function topContent()
    {
        $div = new HTMLDiv("top_content");

        if (is_array($this->topContent)) {
            foreach ($this->topContent as $value) {
                $div->appendChild($value);
            }
        } else {
            $div->appendChild($this->topContent);
        }

        return $div;
    }

    private function topMenu()
    {
        $div = new HTMLDiv("topMenu");

        $leftMenu = $this->topLeftMenu();
        $rightMenu = $this->topRightMenu();

        $div->appendChild([$leftMenu, $rightMenu]);

        $this->topMenu = $div;

        return $this->topMenu;
    }

    private function topLeftMenu()
    {
        $div = new HTMLDiv("float_left");
        $div->class = "float_left";

        $ul = new HTMLElement("ul");

        if (is_array($this->topLeftMenu)) {
            foreach ($this->topLeftMenu as $item) {
                $li = new HTMLElement("li");
                $li->appendChild($item);
                $ul->appendChild($li);
            }
        }

        $div->appendChild($ul);

        $this->topLeftMenu = $div;

        return $this->topLeftMenu;
    }

    private function topRightMenu()
    {
        $div = new HTMLDiv("float_right");
        $div->class = "float_right";

        $ul = new HTMLElement("ul");

        if (is_array($this->topRightMenu)) {
            foreach ($this->topRightMenu as $item) {
                $li = new HTMLElement("li");
                $li->appendChild($item);
                $ul->appendChild($li);
            }
        }

        $div->appendChild($ul);

        $this->topRightMenu = $div;

        return $this->topRightMenu;
    }

    private function content()
    {
        $div = new HTMLDiv('content');
        $div->class = "clear";

        $content = $this->mainContainer();

        $div->appendChild($content);

        $this->content = $div;

        $this->container->appendChild($this->content);

        return $this->content;
    }

    private function mainContainer()
    {
        $div = new HTMLDiv("mainContainer");

        $main = new HTMLDiv("mainContent");
        $main->class = "clear hasLeftContent";

        if (is_array($this->mainContent)) {
            foreach ($this->mainContent as $value) {
                $main->appendChild($value);
            }
        }

        $div->appendChild($main);

        $this->mainContainer = $div;

        return $this->mainContainer;
    }

    /**
     * M�todo addTopContent
     * Adiciona conte�do na parte superior do site
     * abaixo dos menus
     * @param HTMLElement $child conte�do a ser adicionado
     */
    public function addTopContent(HTMLElement $child)
    {
        $this->topContent[] = $child;
    }

    /**
     * M�todo addMainContent
     * @param HTMLElement $child Elemento HTML a ser adicionado na �rea
     * de conte�do principal do site
     */
    public function addMainContent($child)
    {
        $this->mainContent[] = $child;
    }

    /**
     * M�todo addTopLeftMenu
     * Adiciona mais �tens no Menu superior esquerdo da p�gina
     * @param HTMLAnchor $link link a ser adicionado
     */
    public function addTopLeftMenu(HTMLAnchor $link)
    {
        $this->topLeftMenu[] = $link;
    }

    /**
     * M�todo addTopRightMenu
     * Adiciona mais �tens no Menu superior esquerdo da p�gina
     * @param HTMLAnchor $link link a ser adicionado
     */
    public function addTopRightMenu(HTMLAnchor $link)
    {
        $this->topRightMenu[] = $link;
    }

    /**
     * M�todo addLeftMenu
     * Adiciona mais �tens no Menu esquerdo da p�gina
     * @param HTMLAnchor $link link a ser adicionado
     */
    public function addLeftMenu(HTMLAnchor $link)
    {
        $this->leftMenu[] = $link;
    }

    public function addContainer(HTMLElement $container)
    {
        $this->container->appendChild($container);
    }

    public function getOutput()
    {
        //cria a barra superior
        $this->barraSuperior();

        //cria a DIV que armazenar� todo o conte�do;
        $this->container();

        //cria a DIV do conte�do esquerdo
        $this->leftContent();

        //cria o menu do topo da p�gina
        $this->topHeader();

        // cria a DIV de conte�do principal
        $this->content();

        return parent::getOutput();
    }

}
