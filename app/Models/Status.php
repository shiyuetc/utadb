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
    
    public static function updateStatus($id, $newState) {
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
            $state = isset($status) ? $status->state : 0;
            if($state == $newState) {
                throw new Exception('変更前と変更後のステータスが同じです');
            }
            
            if($state == 0) { 
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
                    'state' => $newState
                ]);
                $user[$statusArray[$newState - 1] . '_state_count'] += 1;

            } elseif($newState != 0) { 
                // ステータスの更新
                Status::find($statusId)->update([
                    'state' => $newState,
                    'used_at' => Carbon::now()
                ]);
                $user["{$statusArray[$newState - 1]}_state_count"] += 1;
                $user["{$statusArray[$state - 1]}_state_count"] -= 1;

            } else { 
                // ステータスの削除
                Status::find($statusId)->delete();
                $user["{$statusArray[$state - 1]}_state_count"] -= 1;
                
            }
            $user->save();
            DB::commit();
            return [
                'id' => $id,
                'old_state' => $state,
                'new_state' => $newState
            ];
        } catch (Exception $e){
            DB::rollBack();
            throw new HttpResponseException(response()->json(['errors' => $e->getMessage()], 422));
        }
    }

    public static function userTimeline($id)
    {
        return Status::select('user_statuses.id', 'user_statuses.user_id', 'user_statuses.song_id', 'user_statuses.state', DB::raw('IFNULL(s1.state, 0) as user_state'), 'user_statuses.used_at')
        ->leftjoin('user_statuses as s1', function($join) {
            $join->where('s1.user_id', auth()->id())
            ->on('user_statuses.song_id', '=', 's1.song_id');
        })
        ->where('user_statuses.user_id', $id)
        ->with(['user', 'song'])
        ->orderBy('used_at', 'desc')
        ->get();
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
