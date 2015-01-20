<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/19/15
 * Time: 6:32 PM
 */

require_once(dirname(__FILE__).'/../ClassLoader.php');
ClassLoader::Register();
$base_path = dirname(__FILE__).'/../';

ClassLoader::Load('PHPSanitizer', $base_path);

$sanitizer = PHPSanitizer::getInstance();
$sanitizer->setType(PHPSanitizer::CUSTOM, 'Email', dirname(__FILE__).'/factories/');

$valid_email = "leodaido@gmail.com";
$invalid_email = "some_invalid&email@domain.com,";

echo "Valid email: $valid_email \n";
echo "===========================================\n";
echo "Is valid: ";
echo ($sanitizer->validate($valid_email)) ? "Si\n" :"No\n";
echo "Cleaned:".$sanitizer->cleanup($valid_email)."\n\n\n";
echo "Invalid email: $invalid_email \n";
echo "===========================================\n";
echo "Is valid: ";
echo ($sanitizer->validate($invalid_email)) ? "Si\n" :"No\n";
echo "Cleaned:".$sanitizer->cleanup($invalid_email)."\n\n\n";