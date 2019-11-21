<?php

namespace App\Libraries;

class Rivision {

    public static function page($input)
    {
        return (isset($input) && $input >= 1 && $input <= 9999) ? $input : 1;
    }

    public static function q($input)
    {
        return isset($input) ? urlencode(trim($input)) : '';
    }

}