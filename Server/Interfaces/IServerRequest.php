<?php

namespace Prime\server\interfaces;

/**
 * IServerRequest
 * Define um objeto para fornecer informações de solicitação de cliente para um
 * servlet. O servlet container cria um objeto ServletRequest e passa como um 
 * argumento para o método de serviço da servlet.<br>
 * Um objeto ServletRequest fornece dados, incluindo o nome do parâmetro e 
 * valores, atributos e um fluxo de entrada. Interfaces que se estendem 
 * IServerRequest pode fornecer dados específicos do protocolo adicional 
 * (por exemplo, dados HTTP é fornecida pelo HttpServletRequest. 
 * @date 28/05/2014
 * @author Elton Luiz
 */
interface IServerRequest {
    
    /**
     * Retorna o valor do atributo nomeado como um objeto, ou null se nenhum 
     * atributo do nome dado existe.
     * @param string 
     * return string | NULL
     */
    public function getAttribute($name);
    
    /**
     * Retorna um objeto Enumaration contendo os nomes dos atributos disponíveis
     * para esta requisição
     * @return Enumeration Description
     */
    public function getAttributeNames();
    
    /**
     * 
     */
    public function getCharacterEncoding();
}
