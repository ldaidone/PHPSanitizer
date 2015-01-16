<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/16/15
 * Time: 2:17 PM
 */

class SanitizerLdap extends AbstractSanitizer implements ISanitizer{
    private $pattern = '/(\)|\(|\||&)/';
    private $replacement = '';

    public function validate($string){
        $string = nice_addslashes($string); //gz
        return (!preg_match($this->pattern, $string) > 0);
    }

    public function cleanup($string){
        $string = nice_addslashes($string); //gz
        return preg_replace($this->pattern, $this->replacement, $string);
    }
}