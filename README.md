# PHPSanitizer

This package is a set of classes that will help to validate/sanitize the main set of types 
listed in [OWASP](https://www.owasp.org/index.php/OWASP_PHP_Filters), through a *PHPSanitizer* wrapper class.

It allows to create new validation classes for customs types by extending *AbstractSanitizer* class and implements
*ISanitizer* interface.

## Usage

First, get an instance of *PHPSanitizer*, you can do that through *ClassLoader* class:

```php
    ...
    require_once(dirname(__FILE__).'/<path_to_classes>/ClassLoader.php');
    ClassLoader::Register();
    $base_path = dirname(__FILE__).'/<path_to_PHPSanitizer>/';
    
    ClassLoader::Load('PHPSanitizer', $base_path);
    
    $sanitizer = PHPSanitizer::getInstance();
    ...
```

or just:

```php
    ...
    require_once(dirname(__FILE__).'/<path_to_classes>/PHPSanitizer.php');
    $sanitizer = PHPSanitizer::getInstance();
    ...
```
    
by default it uses "PARANOID" validation, you can change type using `setType($type, $custom_name, $base_path)` method,
where *$type* can be one of:

* PHPSanitizer::PARANOID
* PHPSanitizer::SQL
* PHPSanitizer::SYSTEM
* PHPSanitizer::HTML
* PHPSanitizer::INT
* PHPSanitizer::FLOAT
* PHPSanitizer::LDAP
* PHPSanitizer::UTF8
* PHPSanitizer::CUSTOM

In case of `PHPSanitizer::CUSTOM`, *$custom_name* is required following naming rules that will be detailed in *Extends* section.
*$base_path* is optional. This is used to change default path for *Sanitizers* classes, defaulted in *factories* directory
under the path to *SanitizerFactory* class.

There are two method available in *$sanitizer* instance: *validate($string)* and *cleanup($string)*

`sanitizer->validate($string); //return a boolean`

`$sanitizer->cleanup($string); //returns an string with all invalid characters removed`

## Exteds

To create a new *CUSTOM* sanitizer, you just need to extend *AbstractSanitizer* class and implements *ISanitizer* interface.

```php
    // This file is under examples/factories/.
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
```
    
### Naming convention
    
* Class file name should be camelized, starting with "Sanitizer" followed by type name
* Class name should be camelized, starting with "Sanitizer" followed by type name
* Custom name should be camelized *type* ("Sanitizer" will be added automatically by Factory class)