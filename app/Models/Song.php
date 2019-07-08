<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $table = 'songs';

    public $timestamps = false;
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at'
    ];
}
