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
    private $pattern = '/^[0-9.,]/g';
    private $replacement = '';

    public function validate($string){
        return floatval($string);
    }

    public function cleanup($string){
        return preg_replace($this->pattern, $this->replacement, $string);
    }
}