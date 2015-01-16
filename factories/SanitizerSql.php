<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/16/15
 * Time: 2:13 PM
 */

class SanitizerSql extends AbstractSanitizer implements ISanitizer{
    private $pattern = "/;/"; // jp
    private $replacement = "";

    public function validate($string){
        $string = nice_addslashes($string); //gz
        return (!preg_match($this->pattern, $string) > 0);
    }

    public function cleanup($string){
        $string = nice_addslashes($string); //gz
        return preg_replace($this->pattern, $this->replacement, $string);
    }
}