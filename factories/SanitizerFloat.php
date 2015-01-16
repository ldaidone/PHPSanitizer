<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/16/15
 * Time: 2:47 PM
 */

class SanitizerFloat extends AbstractSanitizer implements ISanitizer{
    private $pattern = '/^[0-9.,]/g';
    private $replacement = '';

    public function validate($string){
        return floatval($string);
    }

    public function cleanup($string){
        return preg_replace($this->pattern, $this->replacement, $string);
    }
}