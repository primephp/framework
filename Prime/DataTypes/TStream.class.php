<?php

namespace Prime\DataTypes;

/**
 * @package Prime\DataTypes
 */
class TStream implements IStreamable {

    /**
     *
     */
    private $hostname;
    private $port;

    public function Stream() {
        /**
         *
         */
    }

    public function valueOf() {
        
    }

    /**
     * 
     */
    public function __toString() {
        return $this->hostname . ":" . $this->port;
    }

    /**
     *
     */
    public function equals() {
        return null;
    }

}


