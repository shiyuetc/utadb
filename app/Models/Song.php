<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    public $timestamps = false;
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [];
    
    protected $hidden = [
        'artist_id', 'created_at'
    ];
}
