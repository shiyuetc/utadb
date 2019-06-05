<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Song;
use App\Libraries\SongPuller\Puller;
use Carbon\Carbon;
use DB;
use Exception;

class Status extends Model
{
    protected $table = 'user_statuses';

    public $timestamps = false;

    protected $fillable = [
        'state', 'used_at'
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
    
    public static function updateStatus($id, $state) 
    {
        $statusArray = [
            'stacked', 'training', 'mastered'
        ];

        $user = auth()->user();
        DB::beginTransaction();
        try {
            // 現在のステータスを取得
            $status = Status::select('id', 'state')
                ->where('user_id', $user->id)
                ->where('song_id', $id)
                ->first();
            $statusId = isset($status) ? $status->id : null;
            $nowState = isset($status) ? $status->state : 0;
            if($nowState == $state) {
                throw new Exception('変更前と変更後のステータスが同じです');
            }
            
            if($nowState == 0) { 
                // ステータスの追加
                if(!Song::where('id', $id)->exists()) {
                    $puller = new Puller();
                    $song = $puller->lookSong($id);
                    if(is_null($song)) {
                        throw new Exception('曲情報の取得に失敗しました');
                    }

                    $result = Song::insert([
                        'id' => $song['id'],
                        'title' => $song['title'],
                        'artist_id' => $song['artist_id'],
                        'artist' => $song['artist'],
                        'image_url' => $song['image_url'],
                        'audio_url' => $song['audio_url']
                    ]);
                    if(!$result) {
                        throw new Exception('曲情報の取得に失敗しました');
                    }
                }

                Status::insert([
                    'user_id' => $user->id,
                    'song_id' => $id,
                    'state' => $state
                ]);
                $user[$statusArray[$state - 1] . '_state_count'] += 1;

            } elseif($state != 0) { 
                // ステータスの更新
                Status::find($statusId)->update([
                    'state' => $state,
                    'used_at' => Carbon::now()
                ]);
                $user["{$statusArray[$state - 1]}_state_count"] += 1;
                $user["{$statusArray[$nowState - 1]}_state_count"] -= 1;

            } else { 
                // ステータスの削除
                Status::find($statusId)->delete();
                $user["{$statusArray[$nowState - 1]}_state_count"] -= 1;
                
            }
            $user->save();
            DB::commit();
            return [
                'id' => $id,
                'old_state' => $nowState,
                'new_state' => $state,
                'user' => $user
            ];
        } catch (Exception $e){
            DB::rollBack();
            throw new HttpResponseException(response()->json(['errors' => $e->getMessage()], 422));
        }
    }

    public static function userStatuses($id, $state = 0, $page = 1)
    {
        $query =  Status::select('user_statuses.song_id', DB::raw('IFNULL(s1.state, 0) as user_state'))
        ->leftjoin('user_statuses as s1', function($join) {
            $join->where('s1.user_id', auth()->id())
            ->on('user_statuses.song_id', '=', 's1.song_id');
        })
        ->where('user_statuses.user_id', $id);

        if($state != 0) $query = $query->where('user_statuses.state', $state);

        return $query
            ->skip(($page - 1) * 50)
            ->take(50)
            ->with(['song'])
            ->get()
            ->sortBy('song.artist')
            ->values();
    }

    public static function getTimeline($id = null)
    {
        $query = Status::select('user_statuses.id', 'user_statuses.user_id', 'user_statuses.song_id', 'user_statuses.state', DB::raw('IFNULL(s1.state, 0) as user_state'), 'user_statuses.used_at')
        ->leftjoin('user_statuses as s1', function($join) {
            $join->where('s1.user_id', auth()->id())
            ->on('user_statuses.song_id', '=', 's1.song_id');
        });

        if(!is_null($id)) $query = $query->where('user_statuses.user_id', $id);

        return $query
            ->with(['user', 'song'])
            ->orderBy('used_at', 'desc')
            ->get();
    }
}
