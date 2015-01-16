<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/15/15
 * Time: 11:12 AM
 */

class SanitizerFactory {
    public static function build($type, $custom_name=null, $base_path=null){
        try{
            $sanitizer = SanitizerFactory::buildClassName($type, $custom_name);
        }catch (InvalidCustomNameException $e){
            throw $e;
        }

        $base_path = (is_null($base_path)) ? dirname(__FILE__).'/factories/' : $base_path;

        require_once('ClassLoader.php');
        ClassLoader::Register();

        ClassLoader::Load($sanitizer, $base_path);
        return new $sanitizer;
    }
    
    protected static function buildClassName($type, $custom_name=null){
        require_once('ClassLoader.php');
        ClassLoader::Register();

        ClassLoader::Load('InvalidCustomNameException', dirname(__FILE__).'/exceptions/');

        if($type==PHPSanitizer::CUSTOM && is_null($custom_name)){
            throw new InvalidCustomNameException('Custom_name could not be NULL when Custom Type is selected.');
        }
        $class_name = "Sanitizer";

        switch($type){
            case PHPSanitizer::PARANOID:
                $class_name .= ucwords("paranoid");
                break;
            case PHPSanitizer::SQL:
                $class_name .= ucwords("sql");
                break;
            case PHPSanitizer::SYSTEM:
                $class_name .= ucwords("system");
                break;
            case PHPSanitizer::HTML:
                $class_name .= ucwords("html");
                break;
            case PHPSanitizer::INT:
                $class_name .= ucwords("int");
                break;
            case PHPSanitizer::FLOAT:
                $class_name .= ucwords("float");
                break;
            case PHPSanitizer::LDAP:
                $class_name .= ucwords("ldap");
                break;
            case PHPSanitizer::UTF8:
                $class_name .= ucwords("utf8");
                break;
            case PHPSanitizer::CUSTOM:
                $class_name .= ucwords(strtolower($custom_name));
                break;
        }
        return $class_name;
    }
}