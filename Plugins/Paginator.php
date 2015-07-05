<?php

namespace Prime\Plugins;

use App\Config\AppConfig,
    Prime\Html\Base\HTMLAnchor,
    Prime\Html\Base\HTMLElement,
    Prime\Html\Base\HTMLImage,
    Prime\Html\Base\HTMLList,
    Prime\Html\Base\HTMLParagraph,
    Prime\Server\Http\Url,
    Prime\Model\DAO\Repository,
    Prime\Model\SQL\SQLCriteria;

/**
 * Descrição da Classe Paginacao
 * @package Prime\Plugins
 * @author TomSailor
 * @since 04/06/2011
 */
class Paginator {

    const PARAM_PAGINA = "pg";

    private $pages;
    private $page = 1;
    private $first;
    private $next;
    private $previous;
    private $last;
    private $params = array();
    /*     * @var SQLCriteria $criteria */
    private $criteria;
    private $model;
    private $order = null;
    private $group = null;
    private $limit = 10;
    private $total;

    /* @var $url Url */
    private $url;

    public function __construct($page = null) {
        $this->setPage($page);
        $this->url = new Url();
    }

    public function setCriteria(SQLCriteria $criteria) {
        $this->criteria = $criteria;
    }

    public function setModel($model_name) {
        $this->model = $model_name;
    }

    public function setOrder($field, $order = "DESC") {
        $this->order = $field . " " . $order;
    }

    public function setGroupBy($fields) {
        $this->group = $fields;
    }

    public function getRepository() {
        if ($this->model) {
            $repository = new Repository($this->model);
        } else {
            trigger_error("ModelClass não definido");
        }

        if (!$this->criteria) {
            $this->criteria = new SQLCriteria();
        }

        $this->total = $repository->count($this->criteria);

        $this->setTotalRecords($this->limit, $this->total);

        if (!is_null($this->order)) {
            $this->criteria->setProperty('order', $this->order);
        }
        if (!is_null($this->group)) {
            $this->criteria->setProperty('group', $this->group);
        }

        $this->criteria->setProperty("limit", ($this->page - 1) * $this->limit . "," . $this->limit);

        return $repository;
    }

    /**
     * Retorna um array de objetos do model passado como parâmetro
     * @return array
     */
    public function getRecords() {
        return $this->getRepository()->load($this->criteria);
    }

    /**
     * Método setTotalRecords
     * Define o total de registros que deverão
     * ser exibidos por página e o total de registros existentes
     * @param type $numberRecords Número de registros por página
     * @param type $totalRecords total de registros existentes
     */
    private function setTotalRecords($numberRecords, $totalRecords) {
        // quantidade de páginas
        $this->pages = ceil($totalRecords / $numberRecords);
        if ($this->pages == 1) {
            $this->pages = 0;
            $this->first = null;
            $this->previous = null;
            $this->next = null;
            $this->last = null;
        } else {
            //$paginas = $paginas;
            if ($this->pages > 1) {
                $this->last = $this->pages;
                $this->first = 1;
            } else {
                $this->first = null;
                $this->previous = null;
                $this->next = null;
                $this->last = null;
            }
        }
    }

    /**
     * Define o Controller e a Action para a
     * criação das URLs necessárias
     * @param type $controller Nome do COntroller
     * @param type $action Action a ser executada
     */
    public function setUrl($controller, $action) {
        $this->url->setAction($action);
        $this->url->setController($controller);
    }

    /**
     * Define os parâmetros que serão passados como QueryString na URL
     * @param type $value Valor do Parâmetro
     * @param type $parameterName Nome do Parâmetro
     */
    public function setParam($value, $parameterName = null) {
        if (is_null($parameterName)) {
            $this->params[] = $value;
        } else {
            $this->params[$parameterName] = $value;
        }
    }

    /**
     * Define a página atual que se encontra
     * @param type $page Número da página atual
     */
    public function setPage($page = 1) {
        if (is_null($page)) {
            $this->page = 1;
            $this->next = $page + 1;
        } else {
            $this->page = $page;
            $this->next = $page + 1;
            $this->previous = $page - 1;
        }
    }

    /**
     * Método setLimit()
     * Define o limite de registro por página
     * @param type $limit 
     */
    public function setLimit($limit = 10) {
        $this->limit = $limit;
    }

    public function getFirstPage() {
        $first = new HTMLImage(AppConfig::baseIcons() . "blue-document-page.png");
        $firstOff = new HTMLImage(AppConfig::baseIcons() . "blue-document-page.png");
        $li = new HTMLElement('li');
        if (($this->page > 1) && ($this->pages > 1)) {
            foreach ($this->params as $param => $value) {
                $this->url->setParam($param, $value);
            }
            $this->url->setParam(self::PARAM_PAGINA, $this->first);
            $primeira = new HTMLAnchor($this->url->queryString(), $first->getOutput());
        } else {
            $primeira = new HTMLAnchor('javascript:void(0);', $firstOff->getOutput());
            $li->addClass('disabled');
        }
        $li->appendChild($primeira);
        return $li;
    }

    public function getNextPage() {
        $next = new \Prime\Html\Base\HTMLSpan('');
        $next->addClass('glyphicon glyphicon-chevron-right');
        $li = new HTMLElement('li');
        if (($this->next <= $this->last) && ($this->pages > 1)) {
            foreach ($this->params as $param => $value) {
                $this->url->setParam($param, $value);
            }
            $this->url->setParam(self::PARAM_PAGINA, $this->next);
            $proxima = new HTMLAnchor($this->url->queryString(), $next->getOutput());
        } else {
            $proxima = new HTMLAnchor('javascript:void(0);', $next->getOutput());
            $li->addClass('disabled');
        }
        $li->appendChild($proxima);
        return $li;
    }

    public function getPreviousPage() {

        $previous = new \Prime\Html\Base\HTMLSpan('');
        $previous->addClass('glyphicon glyphicon-chevron-left');
        $li = new HTMLElement('li');
        if ($this->previous >= 1) {
            foreach ($this->params as $param => $value) {
                $this->url->setParam($param, $value);
            }
            $this->url->setParam(self::PARAM_PAGINA, $this->previous);
            $anterior = new HTMLAnchor($this->url->queryString(), $previous->getOutput());
        } else {
            $anterior = new HTMLAnchor('javascript:void(0);', $previous->getOutput());
            $li->addClass('disabled');
        }
        $li->appendChild($anterior);
        return $li;
    }

    public function getLastPage() {
        $last = new HTMLImage(AppConfig::baseIcons() . "blue-document-page-last.png");

        $li = new HTMLElement('li');
        if (($this->page != $this->pages) && ($this->pages > 1)) {
            foreach ($this->params as $param => $value) {
                $this->url->setParam($param, $value);
            }
            $this->url->setParam(self::PARAM_PAGINA, $this->last);
            $ultima = new HTMLAnchor($this->url->queryString(), $last->getOutput());
        } else {
            $ultima = new HTMLAnchor('javascript:void(0);', $last->getOutput());
            $li->addClass('disabled');
        }
        $li->appendChild($ultima);
        return $li;
    }

    public function getPagination() {
        $ul = new HTMLList();
        $ul->addClass('pagination');
        $ul->appendChild($this->getFirstPage());
        $ul->appendChild($this->getPreviousPage());
        $ul->appendChild($this->getNextPage());
        $ul->appendChild($this->getLastPage());
        return $ul->getOutput();
    }

    public function getPager() {
        $ul = new HTMLList();
        $ul->addClass('pager');
        $liPrevious = $this->getPreviousPage();
        $liPrevious->addClass('previous');
        $ul->appendChild($liPrevious);
        $liNext = $this->getNextPage();
        $liNext->addClass('next');
        $ul->appendChild($liNext);
        return $ul->getOutput();
    }

    /**
     * Retorna um elemento HTMLParagraph com os links do paginador
     * @return \HTMLParagraph 
     * @deprecated since version number
     */
    public function getLinks($align = 'right') {
        $p = new HTMLParagraph();
        $p->setAlignment($align);
        $p->appendChild($this->getFirstPage()->getOutput() . ' ' .
                $this->getPreviousPage()->getOutput() . ' ' .
                $this->getNextPage()->getOutput() . ' ' .
                $this->getLastPage()->getOutput());
        return $p;
    }

    public function getTotal() {
        return $this->total;
    }

    /**
     * Retorna o total de páginas
     * @return int 
     */
    public function getTotalPages() {
        return $this->pages;
    }

    public function getlastRegistryOfPage() {
        $value = ($this->page * $this->limit);
        if ($this->total < $value)
            $value = $this->total;
        return $value;
    }

    public function getFirstRegistryOfPage() {
        $value = (($this->page - 1) * $this->limit) + 1;

        return $value;
    }

}
