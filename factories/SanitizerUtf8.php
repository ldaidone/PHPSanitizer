<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/16/15
 * Time: 3:08 PM
 */

class SanitizerUtf8 extends AbstractSanitizer implements ISanitizer{
    public function validate($string){
        return $this->my_utf8_decode($string);
    }

    public function cleanup($string){
        return $this->my_utf8_decode($string);
    }
}