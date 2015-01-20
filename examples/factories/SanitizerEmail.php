<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/19/15
 * Time: 6:39 PM
 */

require_once(dirname(__FILE__).'/../../factories/AbstractSanitizer.php');
require_once(dirname(__FILE__).'/../../factories/ISanitizer.php');

class SanitizerEmail extends AbstractSanitizer implements ISanitizer{
    private $pattern = "/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{1,4})(\]?)$/";
    private $pattern_replace = "/[\;\#\n\r\*\'\"<>&\%\!\(\)\{\}\[\]\?\\/\s,]/";
    private $replacement = "";

    public function validate($string){
        return preg_match($this->pattern, $string);
    }

    public function cleanup($email){
        $email = trim($email);
        $email = str_replace(" ", "", $email);
        if(count(explode('@',$email))>2){
            throw new Exception('Invalid email address');
        }
        return preg_replace($this->pattern_replace, $this->replacement, $email);
    }
}