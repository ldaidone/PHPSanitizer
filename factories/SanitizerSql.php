<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/16/15
 * Time: 2:13 PM
 */

require_once(dirname(__FILE__).'/AbstractSanitizer.php');
require_once(dirname(__FILE__).'/ISanitizer.php');

class SanitizerSql extends AbstractSanitizer implements ISanitizer{
    private $pattern = "/;/";
    private $replacement = "";

    public function validate($string){
        $string = $this->nice_addslashes($string);
        return (!preg_match($this->pattern, $string) > 0);
    }

    public function cleanup($string){
        $string = $this->nice_addslashes($string);
        return preg_replace($this->pattern, $this->replacement, $string);
    }
}