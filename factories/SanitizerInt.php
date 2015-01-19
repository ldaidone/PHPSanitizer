<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/16/15
 * Time: 2:23 PM
 */

require_once(dirname(__FILE__).'/AbstractSanitizer.php');
require_once(dirname(__FILE__).'/ISanitizer.php');

class SanitizerInt extends AbstractSanitizer implements ISanitizer{
    private $pattern = '/([\D]+)/';
    private $replacement = '';

    public function validate($string){
        return (is_numeric($string) && $this->isValidRange($this->getIntFromString($string)[0]));
    }

    public function cleanup($string){
        return $this->getIntFromString($string)[0];
    }

    protected function getIntFromString($string){
        return $numericval = sscanf($string, "%d");
    }

    protected function isValidRange($number){
        $result = false;
        if($this->is64Bits()){
            $result = (($number >= -9223372036854775808) && ($number <= 9223372036854775807));
        }elseif($this->is32Bits()){
            $result = (($number >= -2147483648) && ($number <= 2147483647));
        }
        return $result;
    }
}