<?php

namespace App\Models;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;

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

    public static function likeCreate($activity_id)
    {
        $activity = Activity::find($activity_id);
        if(is_null($activity)) return [];
        $response = [];
        try {
            DB::beginTransaction();
            $like = DB::table('likes')->insert([
                'activity_id' => $activity_id,
                'user_id' => auth()->id()
            ]);
            $activity->like_count += 1;
            $activity->save();
            Notification::create($activity->user->id ,$activity->id, 'like');
            DB::commit();
            $response['post'] = true;
        } catch (Exception $e){
            DB::rollBack();
            $response['post'] = false;
        }
        $response['like_count'] = $activity->like_count;
        return $response;
    }

    public static function likeDestroy($activity_id)
    {
        $activity = Activity::find($activity_id);
        if(is_null($activity)) return [];
        $response = [];
        try {
            DB::beginTransaction();
            $like = DB::table('likes')
                ->where('activity_id', $activity_id)
                ->where('user_id', auth()->id())
                ->delete();
            if($like != 1) throw new Exception();
            $activity->like_count -= 1;
            $activity->save();
            Notification::remove($activity->user->id ,$activity->id);
            DB::commit();
            $response['post'] = true;
        } catch (Exception $e){
            DB::rollBack();
            $response['post'] = false;
        }
        $response['like_count'] = $activity->like_count;
        return $response;
    }
}
