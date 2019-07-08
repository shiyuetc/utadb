<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Activity extends Model
{
    protected $table = 'activities';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'kind', 'created_at'
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

    public static function getTimeline($user_id = null, $next_id = null)
    {
        $query = Activity::select('activities.id', 'activities.user_id', 'activities.song_id', 'activities.old_state', 'activities.state', DB::raw('IFNULL(statuses.state, 0) as my_state'),  DB::raw('IFNULL(activities.like_count, 0) as like_count'), DB::raw('IF(likes.id IS NOT NULL, 1, 0) as is_liked'), 'activities.created_at')
        ->leftjoin('statuses', function($join) {
            $join->where('statuses.user_id', auth()->id())
            ->on('activities.song_id', '=', 'statuses.song_id');
        })
        ->leftjoin('likes', function($join2) {
            $join2->where('likes.user_id', auth()->id())
            ->on('activities.id', '=', 'likes.activity_id');
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
