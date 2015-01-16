<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/16/15
 * Time: 2:23 PM
 */

class SanitizerInt extends AbstractSanitizer implements ISanitizer{
    private $pattern = '/^[0-9]/g';
    private $replacement = '';

    public function validate($string){
        return intval($string);
    }

    public function cleanup($string){
        return preg_replace($this->pattern, $this->replacement, $string);
    }
}