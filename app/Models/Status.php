<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'state', 'used_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id', 'song_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function song()
    {
        return $this->belongsTo('App\Models\Song');
    }
    
    public static function commonCount($user_id)
    {
        if(!auth()->check() || auth()->id() == $user_id) return 0;
        return Status::select('statuses.song_id')
        ->join('statuses as s1', function($join) {
            $join->where('s1.user_id', auth()->id())
            ->where('s1.state', 3)
            ->on('statuses.song_id', '=', 's1.song_id');
        })
        ->where('statuses.user_id', $user_id)
        ->where('statuses.state', 3)
        ->count();
    }
    
}