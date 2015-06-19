<?php

namespace Prime\DataTypes\Interfaces;

/**
 * @package Prime\DataTypes\Interfaces
 * 
 */
interface IStreamable {

    /**
     *
     */
    public function openStream();

    public function closeStream();

    /**
     *
     */
    public function writeStream();

    /**
     *
     */
    public function readStream();
}
