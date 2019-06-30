<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Activity extends Model
{
    protected $table = 'activities';

    public $timestamps = false;

    public $incrementing = false;
    
    protected $keyType = 'string';
    
    protected $fillable = [
        'id', 'kind', 'created_at'
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
    
    public static function createPrimaryKey()
    {
        return str_pad(str_replace('.', '', microtime(true)), 14, '0', STR_PAD_RIGHT);
    }

    public static function createActivity($user_id, $song_id, $old_state, $state)
    {
        Activity::insert([
            'id' => Activity::createPrimaryKey(),
            'user_id' => $user_id,
            'song_id' => $song_id,
            'old_state' => $old_state,
            'state' => $state
        ]);
    }

    public static function getTimeline($user_id = null, $next_id = null)
    {
        $query = Activity::select('activities.id', 'activities.user_id', 'activities.song_id', 'activities.old_state', 'activities.state', DB::raw('IFNULL(statuses.state, 0) as my_state'), 'activities.created_at')
        ->leftjoin('statuses', function($join) {
            $join->where('statuses.user_id', auth()->id())
            ->on('activities.song_id', '=', 'statuses.song_id');
        });

        // 対象のユーザーのみを取得
        if(!is_null($user_id)) $query = $query->where('activities.user_id', $user_id);

        // next以降のアクティビティを取得
        if(!is_null($next_id)) $query = $query->where('activities.id', '<', $next_id);

        return $query
            ->take(50)
            ->with(['user', 'song'])
            ->orderBy('id', 'desc')
            ->get();
    }
}
