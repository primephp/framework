<?php

namespace Prime\Server\Http;

use Symfony\Component\HttpFoundation\JsonResponse as SymfonyJsonResponse;

/**
 * @name JsonResponse
 * @package Prime\Server\Http
 * @author Elton Luiz
 *        
 */
class JsonResponse extends SymfonyJsonResponse
{

    /**
     * Adiciona um conteúdo para o Json encode
     * @param mixed $item
     * @param mixed $value
     */
    public function addData($item, $value)
    {
        $data = $this->data;
        $data[$item] = $value;
        $this->setData($data);
    }

}
