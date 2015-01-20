<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/14/15
 * Time: 3:48 PM
 */

class PHPSanitizer {
    const PARANOID = 1;
    const SQL = 2;
    const SYSTEM = 4;
    const HTML = 8;
    const INT = 16;
    const FLOAT = 32;
    const LDAP = 64;
    const UTF8 = 128;
    const CUSTOM = 256;

    private $type = PHPSanitizer::PARANOID;
    private $sanitizer;
    private $custom_name;

    public static function getInstance(){
        static $instance = null;
        if($instance===null){
            $instance = new PHPSanitizer();
        }
        return $instance;
    }

    public function validate($string){
        return $this->sanitizer->validate($string);
    }

    public function cleanup($string){
        return $this->sanitizer->cleanup($string);
    }

    public function setType($type=PHPSanitizer::PARANOID, $custom_name=null, $base_path=null){
        if($type == PHPSanitizer::CUSTOM && is_null($custom_name)){
            throw new InvalidCustomNameException("Custom type required custom name.");
        }
        $this->type = $type;
        $this->custom_name = $custom_name;
        try{
            $this->sanitizer = SanitizerFactory::build($this->type,$this->custom_name, $base_path);
        }catch (Exception $e){
            throw $e;
        }
    }

    // Protected Scope

    protected function __construct(){
        require_once('ClassLoader.php');
        ClassLoader::Register();

        ClassLoader::Load('SanitizerFactory', dirname(__FILE__).'/');
        ClassLoader::Load('InvalidCustomNameException', dirname(__FILE__).'/exceptions/');
        try{
            $this->sanitizer = SanitizerFactory::build($this->type,null,null);
        }catch (InvalidCustomNameException $e){
            throw $e;
        }
    }


    // Private Scope

    /**
     * Private clone method to prevent cloning of the instance of the
     * *PHPSanitizer* instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the *PHPSanitizer*
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }
}