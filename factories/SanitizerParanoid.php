<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/16/15
 * Time: 12:36 PM
 */

class SanitizerParanoid extends AbstractSanitizer implements ISanitizer{
    private $pattern = "/[^a-zA-Z0-9]/";
    private $replacement = " ";

    public function validate($string){
        return (preg_match($this->pattern, $string) > 0);
    }

    public function cleanup($string){
        return preg_replace($this->pattern, $this->replacement, $string);
    }
}