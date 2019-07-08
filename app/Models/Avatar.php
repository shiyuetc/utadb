<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $table = 'avatars';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;
    
}
