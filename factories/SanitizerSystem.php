<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/16/15
 * Time: 1:21 PM
 */

class SanitizerSystem extends AbstractSanitizer implements ISanitizer{
    private $pattern = array('/(;|\||`|>|<|&|^|"|\'\."\n|\r|\'"\.\'|{|}|[|]|\)|\()/i', '/\$/');
    private $replacement = array('', '\\\$');

    public function validate($string){
        return ((preg_match_all($this->pattern[0],$string)===0) || (preg_match_all($this->pattern[1],$string)===0));
    }

    public function cleanup($string){
        return preg_replace($this->pattern[1], $this->replacement[1], preg_replace($this->pattern[0], $this->replacement[0], $string));
    }
}