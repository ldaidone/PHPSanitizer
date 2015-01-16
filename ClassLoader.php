<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/16/15
 * Time: 12:09 PM
 *
 * @author Leo Daidone
 */

class ClassLoader {

    public static function Register() {
        return spl_autoload_register(array('ClassLoader', 'Load'));
    }

    public static function Load($strObjectName, $base_path=null) {
        #if(class_exists($strObjectName) === false) {
        #    return false;
        #}

        $base_path = (is_null($base_path)) ? dirname(__FILE__) : $base_path;
        $strObjectFilePath = $base_path . $strObjectName . '.php';

        if((file_exists($strObjectFilePath) === false) || (is_readable($strObjectFilePath) === false)) {
            return false;
        }

        require_once($strObjectFilePath);
    }
}