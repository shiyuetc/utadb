<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Post extends Model
{
    protected $table = 'posts';

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
        $query = Post::select('posts.id', 'posts.user_id', 'posts.song_id', 'posts.old_state', 'posts.state', DB::raw('IFNULL(statuses.state, 0) as my_state'),  DB::raw('IFNULL(posts.like_count, 0) as like_count'), DB::raw('IF(likes.id IS NOT NULL, 1, 0) as is_liked'), 'posts.created_at')
        ->leftjoin('statuses', function($join) {
            $join->where('statuses.user_id', auth()->id())
            ->on('posts.song_id', '=', 'statuses.song_id');
        })
        ->leftjoin('likes', function($join2) {
            $join2->where('likes.user_id', auth()->id())
            ->on('posts.id', '=', 'likes.post_id');
        });

        // 対象のユーザーのみを取得
        if(!is_null($user_id)) $query = $query->where('posts.user_id', $user_id);

        // next以降のアクティビティを取得
        if(!is_null($next_id)) $query = $query->where('posts.id', '<', $next_id);

        return $query
            ->take(50)
            ->with(['user', 'song'])
            ->orderBy('id', 'desc')
            ->get();
    }
}
