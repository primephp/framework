<?php

namespace App\Modules\Index\Controller;

/**
 * Descrição do Controller IndexController
 * Pertencente ao Módulo Index
 * @name IndexController
 * @package App\Modules\Index\Controller
 * @createAt {{ date }}
 */
class IndexController extends \Prime\Controller\AbstractController {

    public function index() {
        $template = new \Prime\View\Template('@prime/200.twig');
        $template->assign('text', __METHOD__);
        return $this->getResponse()->setContent($template->getOutput());
    }

    public function create() {
//para criação de um novo item
    }

    public function destroy($id) {
//para deleção ou exclusão de um item
    }

    public function update($id) {
//para atualização de um item
    }

}
