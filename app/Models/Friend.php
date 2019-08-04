<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $table = 'friends';
    
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function following()
    {
        return $this->belongsTo('App\Models\User');
    }
}
