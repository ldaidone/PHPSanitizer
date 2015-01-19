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
// HTML case
$str_invalid = 'I have lots of <a href="http://my.site.com">links</a> on this <a href="http://my.site.com">page</a> that I want to <a href="http://my.site.com">find</a> the positions.';
$str_valid = htmlentities($str_invalid, ENT_QUOTES);

$sanitizer->setType(PHPSanitizer::HTML);

pp('HTML', $str_valid, $str_invalid, $sanitizer->cleanup($str_valid),$sanitizer->cleanup($str_invalid));

echo "\n\n";
// INT case
$str_valid = "9223372036854775807";
$str_invalid = '-386.1e';

$sanitizer->setType(PHPSanitizer::INT);

pp('INT', $str_valid, $str_invalid, $sanitizer->cleanup($str_valid),$sanitizer->cleanup($str_invalid));

echo "\n\n";
// FLOAT case
$str_valid = "9223372036.854775807e-20";
$str_invalid = '1.8e307';

$sanitizer->setType(PHPSanitizer::FLOAT);

pp('FLOAT', $str_valid, $str_invalid, $sanitizer->cleanup($str_valid),$sanitizer->cleanup($str_invalid));

echo "\n\n";