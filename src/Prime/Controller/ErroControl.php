<?php

namespace Prime\Controller;

use Prime\Html\Base\HTMLDiv,
    Prime\Html\Base\HTMLElement,
    Prime\Html\Page\HTMLPage,
    Prime\Server\Http\Router;

/**
 * Descrição de ErroControl
 * Define as Action para ações de erro
 * @package Prime\Controller
 * @author tom
 */
class ErroControl extends Controller {

    const NAME = 'Erro';
    const ACTION_401 = 'unauthorized';
    const ACTION_403 = 'forbidden';
    const ACTION_404 = 'noFound';

    public function indexAction() {
        ;
    }

    /**
     * ERRO 404
     * Página não encontrada
     */
    public function noFoundAction() {
        $page = new HTMLPage('Página não encotrada');

        $h1 = new HTMLElement('h1');
        $h1->appendChild('Prime PHP Framework');
        $h1->setStyle('text-align', 'center');
        $page->appendChild($h1);

        $h2 = new HTMLElement('h2');
        $h2->appendChild('Erro 404 - Página não encontrada');
        $h2->setStyle('text-align', 'center');
        $page->appendChild($h2);

        $h2 = new HTMLElement('h4');
        $h2->appendChild('Verifique a URL digitada na barra de endereço.');
        $h2->setStyle('text-align', 'center');
        $page->appendChild($h2);

        Router::redirect('/', 5);

        $page->printOut();
    }

    public function forbiddenAction() {
        $page = new HTMLPage('Acesso não permitido');

        $h1 = new HTMLElement('h1');
        $h1->appendChild('Prime PHP Framework');
        $h1->setStyle('text-align', 'center');
        $page->appendChild($h1);

        $h2 = new HTMLElement('h2');
        $h2->appendChild('Erro 403 - Acesso não permitido');
        $h2->setStyle('text-align', 'center');
        $page->appendChild($h2);

        $divPanel = new HTMLDiv();



        $page->printOut();
    }

    public function unauthorizedAction() {
        $page = new HTMLPage('Acesso não permitido');

        $h1 = new HTMLElement('h1');
        $h1->appendChild('Prime PHP Framework');
        $h1->setStyle('text-align', 'center');
        $page->appendChild($h1);

        $h2 = new HTMLElement('h2');
        $h2->appendChild('Erro 401 - Acesso não permitido');
        $h2->setStyle('text-align', 'center');
        $page->appendChild($h2);

        $h2 = new HTMLElement('h3');
        $h2->appendChild('É necessário estar logado para acessar esta área.');
        $h2->setStyle('text-align', 'center');
        $page->appendChild($h2);


        Router::redirect('/', 5);
        $page->printOut();
    }

}


