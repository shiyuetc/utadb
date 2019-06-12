<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    public $timestamps = false;

    protected $keyType = 'string';

    public static function search($category)
    {
        return Avatar::where('category', $category)
            ->get();
    }
}
