<?php

namespace Prime\Io\Interfaces;

use Serializable;

/**
 * Descrição da Interface ISerializable
 * Define uma interface para objetos que podem ter seu conteúdo serializado
 * @package Prime\InOut
 * @dateCreate 28/05/2014
 * @author Elton Luiz
 */
interface SerializableInterface {

    public function serialize();
}
