<?php

namespace Prime\Core;

/**
 * Número classe abstrata é a superclasse das classes BigDecimal, BigInteger, 
 * byte, double, float, inteiro, longo e curto.<br>
 * As subclasses de número deve fornecer métodos para converter o valor numérico 
 * representado para byte, double, float, int, long e short.
 * 
 *  @author      Elton Luiz
 *  @dateCreate 29/05/2014
 * 
 */
abstract class Number extends Object
{

    abstract function getValue();

    /**
     *  Retorna o valor de um número especificado número em <code>int</code>.
     *  Isto pode envolver o arredondamento ou truncagem.
     * 
     *  @return int o valor numérico representado por este objeto após a conversão
     * para o tipo <code> int </ code>.
     * 
     */
    public function intValue()
    {
        return (int) $this->getValue();
    }

    /**
     *  Returns the value of the specified number as a <code>float</code>.
     *  This may involve rounding.
     * 
     *  @return  the numeric value represented by this object after conversion
     *           to type <code>float</code>.
     * 
     */
    public function floatValue()
    {
        return (float) $this->getValue();
    }

    /**
     *  Returns the value of the specified number as a <code>byte</code>.
     *  This may involve rounding or truncation.
     * 
     *  @return  the numeric value represented by this object after conversion
     *           to type <code>byte</code>.
     *  @since   JDK1.1
     * 
     */
    public function byteValue()
    {
        return $this->getValue();
    }

}
