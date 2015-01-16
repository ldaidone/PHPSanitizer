<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/16/15
 * Time: 3:58 PM
 */

require_once(dirname(__FILE__).'/../ClassLoader.php');
ClassLoader::Register();
$base_path = dirname(__FILE__).'/../';

ClassLoader::Load('PHPSanitizer', $base_path);

$sanitizer = PHPSanitizer::getInstance();

// pretty print function for examples output
function pp($type, $str_valid, $str_invalid, $cleaned_valid, $cleaned_invalid){
    echo "Validation test for $type Type:\n";
    echo "==================================\n";
    echo "Valid String ($str_valid):\n";
    echo "This is a valid string: ".$str_valid."\n";
    echo "Cleaned: $cleaned_valid \n";
    echo "-------------------------------------------------\n";
    echo "Invalid String ($str_invalid):\n";
    echo "This is an invalid string: ".$str_invalid."\n";
    echo "Cleaned: $cleaned_invalid \n";
    echo "-------------------------------------------------\n";
    echo "\n\n";
}

echo "\n";
// PARANOID case
$str_valid = "ThisShouldBeValid";
$str_invalid = "This would be an invalid String 1,2,3...";

pp('PARANOID', $str_valid, $str_invalid, $sanitizer->cleanup($str_valid),$sanitizer->cleanup($str_invalid));

echo "\n\n";
// SYSTEM case
$str_valid = "This would be an invalid String 1,2,3";
$str_invalid = 'home/user/$ ls -ltra | wc -l 2>1&; (ps aux | grep apache)';

$sanitizer->setType(PHPSanitizer::SYSTEM);

pp('SYSTEM', $str_valid, $str_invalid, $sanitizer->cleanup($str_valid),$sanitizer->cleanup($str_invalid));

echo "\n\n";
// SQL case
$str_valid = "This would be an invalid String 1,2,3";
$str_invalid = 'SELECT * FROM USERS WHERE 1=1;';

$sanitizer->setType(PHPSanitizer::SQL);

pp('SQL', $str_valid, $str_invalid, $sanitizer->cleanup($str_valid),$sanitizer->cleanup($str_invalid));

echo "\n\n";