<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Status extends Model
{
    protected $table = 'user_statuses';

    public $timestamps = false;

    protected $fillable = [
        'state'
    ];

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
    
    public static function publicTimeline()
    {
        return Status::select('user_statuses.id', 'user_statuses.user_id', 'user_statuses.song_id', 'user_statuses.state', DB::raw('IFNULL(s1.state, 0) as user_state'), 'user_statuses.used_at')
        ->leftjoin('user_statuses as s1', function($join) {
            $join->where('s1.user_id', auth()->id())
            ->on('user_statuses.song_id', '=', 's1.song_id');
        })
        ->with(['user', 'song'])
        ->orderBy('used_at', 'desc')
        ->get();
    }
}
