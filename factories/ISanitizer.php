<?php
/**
 * Created by PhpStorm.
 * User: leodaido
 * Date: 1/16/15
 * Time: 12:34 PM
 */

interface ISanitizer {
    public function validate($string);
    public function cleanup($string);
}