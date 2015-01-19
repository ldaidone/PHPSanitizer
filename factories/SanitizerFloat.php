<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/16/15
 * Time: 2:47 PM
 */

require_once(dirname(__FILE__).'/AbstractSanitizer.php');
require_once(dirname(__FILE__).'/ISanitizer.php');

class SanitizerFloat extends AbstractSanitizer implements ISanitizer{
    private $max_32bit_positive = 1.0E+308;
    private $max_32bit_negative = -9.88131291682E-324;
    private $min_32bit_positive = 9.88131291682E-324;
    private $min_32bit_negative = -1.0E+308;

    private $max_64bit_positive = 1.8e308;
    private $max_64bit_negative = -9.88131291682E-324;
    private $min_64bit_positive = 9.88131291682E-324;
    private $min_64bit_negative = -1.8e308;

    public function validate($string){
        $_float = $this->getFloatFromString($string)[0];
        return (is_numeric($string) && is_float($_float) && $this->isValidRange($_float));
    }

    public function cleanup($string){
        return (float)$this->getFloatFromString($string)[0];
    }

    protected function getFloatFromString($string){
        return sscanf($string, "%f");
    }

    protected function isValidRange($number){
        $result = false;
        if($this->is64Bits()){
            if($number===abs($number)){
                $result = (($number >= $this->min_64bit_positive) && ($number <= $this->max_64bit_positive));
            }else{
                $result = (($number >= $this->min_64bit_negative) && ($number <= $this->max_64bit_negative));
            }
        }elseif($this->is32Bits()){
            if($number===abs($number)){
                $result = (($number >= $this->min_32bit_positive) && ($number <= $this->max_32bit_positive));
            }else{
                $result = (($number >= $this->min_32bit_negative) && ($number <= $this->max_32bit_negative));
            }
        }
        return $result;
    }
}