<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/16/15
 * Time: 1:07 PM
 */

require_once(dirname(__FILE__).'/ISanitizer.php');

abstract class AbstractSanitizer implements ISanitizer{

    protected $register_globals;
    protected $magic_quotes;

    public function __construct(){
        // get register_globals ini setting - jp
        $_register_globals = (bool) ini_get('register_gobals');
        $this->register_globals = ($_register_globals == TRUE) ? 1 : 0;

        // get magic_quotes_gpc ini setting - jp
        $_magic_quotes = (bool) ini_get('magic_quotes_gpc');
        $this->magic_quotes = ($_magic_quotes == TRUE) ? 1 : 0;
    }

    // addslashes wrapper to check for gpc_magic_quotes - gz
    protected function nice_addslashes($string)
    {
        // if magic quotes is on the string is already quoted, just return it
        if($this->magic_quotes)
            return $string;
        else
            return addslashes($string);
    }

    // internal function for utf8 decoding
    // thanks to Hokkaido for noticing that PHP's utf8_decode function is a little
    // screwy, and to jamie for the code
    protected function my_utf8_decode($string)
    {
        return strtr($string,
            "???????��������������������������������������������������������������",
            "SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
    }

    public function validate($string){

    }

    public function cleanup($string){

    }
}