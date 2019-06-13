<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deactivate extends Model
{
    public $timestamps = false;

    public static function isApplied($user_id)
    {
        return Deactivate::where('user_id', $user_id)->exists();
    }

    public static function appli($user_id)
    {
        return Deactivate::insert(['user_id' => $user_id]);
    }

    public static function cancel($user_id)
    {
        return Deactivate::where('user_id', $user_id)->delete();
    }
}
