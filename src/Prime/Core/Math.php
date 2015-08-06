<?php

namespace Prime\Core;

/**
 * @name TMath
 * @package Prime\DataTypes
 */
class Math extends Object
{

    /**
     *
     */
    private $initialValue;
    private $lastOutputValue;
    private $calcLeftNumber;
    private $calcRightNumber;
    private $stringVal;

    /**
     *
     */
    public function Math($leftNumber, $rightNumber)
    {
        if (gettype($leftNumber) == "string") {
            self :: stringVerify($leftNumber);
        } else if (gettype($leftNumber) == "integer") {
            self :: numberLeftVerify($leftNumber);
            if ($rightNumber) {
                self :: numberRightVerify($rightNumber);
            }
        } else {
            
        }
        $this->initialValue = $leftNumber;
    }

    public function getAbsoluteValueOf()
    {
        $this->lastOutputValue = abs($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function getInverseCossinOf()
    {
        $this->lastOutputValue = acos($this->calcNumber);
        return $this->lastOutputValue;
    }

    /**
     *
     */
    public function getInverseHiperbolicCossinOf()
    {
        $this->lastOutputValue = acosh($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function getInverseSinOf()
    {
        $this->lastOutputValue = asin($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    /**
     *
     */
    public function getInverseHiperbolicSinOf()
    {
        $this->lastOutputValue = asinh($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function getInverseTangentOf()
    {
        $this->lastOutputValue = atan($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function getInverseHiperbolicTangentOf()
    {
        $this->lastOutputValue = atanh($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function convertBinaryToDecimalOf($binary_string)
    {
        $this->lastOutputValue = bindec($binary_string);
        return $this->lastOutputValue;
    }

    public function roundToHighier()
    {
        $this->lastOutputValue = ceil($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function getCossinOf()
    {
        $this->lastOutputValue = cos($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function getHiperbolicCossinOf()
    {
        $this->lastOutputValue = cosh($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function convertDecimalToBinary()
    {
        $this->lastOutputValue = decbin($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function convertDecimalToHex()
    {
        $this->lastOutputValue = dechex($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function convertDecimalToOctal()
    {
        $this->lastOutputValue = decoct($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function convertDegreeToRadian()
    {
        $this->lastOutputValue = deg2rad($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function roundToLower()
    {
        $this->lastOutputValue = floor($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function getRemainder($divisor)
    {
        $this->lastOutputValue = ($this->calcLeftNumber % $this->calcRightNumber);
        return $this->lastOutputValue;
    }

    public function getRandomicBetween()
    {
        $this->lastOutputValue = rand($this->calcLeftNumber, $this->calcRightNumber);
        return $this->lastOutputValue;
    }

    public function convertHexToDecimal($hex)
    {
        $this->lastOutputValue = hexdec($this->stringVal);
        return $this->lastOutputValue;
    }

    /**
     * @return boolean
     * Retorna boolean true se o numero for finito
     */
    public function isFinit()
    {
        $this->lastOutputValue = is_finite($this->calcLeftNumber);
        return (boolean) $this->lastOutputValue;
    }

    /*     * ***
     *
     *
     */

    public function isInifinit()
    {
        return is_infinite($this->calcLeftNumber);
    }

    public function isNAN()
    {
        return is_nan($number->__toString());
    }

    public function convertRadianToDegree()
    {
        $this->lastOutputValue = rad2deg($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function convertOctalToDecimal()
    {
        $this->lastOutputValue = octdec($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function PI()
    {
        $this->lastOutputValue = pi();
        return $this->lastOutputValue;
    }

    public function getSinOf()
    {
        $this->lastOutputValue = sin($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function getSquareRootOf()
    {
        $this->lastOutputValue = sqrt($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function getSinHiperbolicOf()
    {
        $this->lastOutputValue = sinh($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function getTangentOf()
    {
        $this->lastOutputValue = tan($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    public function getTangentHiperbolicOf()
    {
        $this->lastOutputValue = tanh($this->calcLeftNumber);
        return $this->lastOutputValue;
    }

    /**
     *
     */
    public function getHipotenuseValue($left, $right)
    {
        try {
            self :: numberLeftVerify($left);
            self :: numberRightVerify($right);
            $this->lastOutputValue = hypot($this->calcLeftNumber, $this->calcRightNumber);
            return $this->lastOutputValue;
        } catch (Exception $e) {
            echo "Erro linha: " . $e->getLine() . " - Desc: " . $e->getMessage() . "- Arquivo:" . $e->getFile();
        }
    }

    public function getMaxBetween()
    {
        $this->lastOutputValue = max($this->calcLeftNumber, $this->calcRightNumber);
        return $this->lastOutputValue;
    }

    public function getMinBetween()
    {
        $this->lastOutputValue = min($this->calcLeftNumber, $this->calcRightNumber);
        return $this->lastOutputValue;
    }

    public function getPowerOf()
    {
        $this->lastOutputValue = pow($this->calcLeftNumber, $this->calcRightNumber);
        return $this->lastOutputValue;
    }

    public function getRandomValueOf()
    {
        $this->lastOutputValue = rand($this->calcLeftNumber, $this->calcRightNumber);
        return $this->lastOutputValue;
    }

    public function getRoundedValueOf()
    {
        $this->lastOutputValue = round($this->calcLeftNumber, $this->calcRightNumber);
        return $this->lastOutputValue;
    }

    /**
     *
     */
    public function doBaseConvertionOf($frombase, $tobase)
    {
        if (!is_numeric($tobase) || !is_numeric($frombase)) {
            throw new Exception("Chamada de m�todo inv�lido");
        }
        $this->lastOutputValue = base_convert($this->calcLeftNumber, $frombase, $tobase);
        return $this->lastOutputValue;
    }

    public function getInitialValue()
    {
        return $this->initialValue;
    }

    public function getLastOutputValue()
    {
        return $this->lastOutputValue;
    }

    private function numberLeftVerify(Object $number)
    {
        if (!is_numeric($number)) {
            throw new Exception("Tipo ilegal, deveria ser num�rico... ");
        }
        $this->calcLeftNumber = $number;
        return true;
    }

    private function numberRightVerify($number)
    {
        if (!is_numeric($number)) {
            throw new Exception("Tipo ilegal, deveria ser num�rico... ");
        }
        $this->calcRightNumber = $number;
        return true;
    }

    private function stringVerify($str)
    {
        if (is_string($str)) {
            $this->stringVal = $str;
        } else {
            throw new Exception("Tipo ilegal, deveria ser String... ");
        }
        return true;
    }

}
