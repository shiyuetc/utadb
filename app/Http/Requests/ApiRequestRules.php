<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;

class ApiRequestRules
{
    public static function getPageRule()
    {
        return 'required|numeric|between:1,9999';
    }

    public static function getQRule()
    {
        return 'required|string|between:1,20';
    }

    public static function getSourceRule()
    {
        return 'required|numeric|between:0,1';
    }

    public static function getSongIdRule()
    {
        return 'required|string|digits_between:5,18|regex:/^[0-1].*/';
    }

    public static function getStateRule()
    {
        return 'required|numeric|between:0,3';
    }

    public static function getUserIdRule()
    {
        return 'required|numeric';
    }
}
