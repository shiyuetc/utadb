<?php

namespace App\Models;

use App\Models\Activity;
use App\Models\Song;
use App\Libraries\SongPuller\Puller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;
use DB;
use Exception;

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

    // 引数の曲idの曲を登録中のユーザーの配列を返す
    public static function lookup($song_id)
    {
        $response = [1 => [], 2 => [], 3 => []];
        $statuses = Status::select('user_id', 'state')
            ->where('song_id', $song_id)
            ->orderBy('used_at', 'desc')
            ->with('user')
            ->get();
        foreach($statuses as $status) {
            $response[(int)$status['state']][] = $status['user'];
        }
        return $response;
    }

    // ステータスを更新する
    public static function edit($song_id, $state) 
    {
        $statusArray = ['stacked', 'training', 'mastered'];
        $user = auth()->user();

        DB::beginTransaction();
        try {
            // 現在のステータスを取得
            $status = Status::select('id', 'state')
                ->where('user_id', $user->id)
                ->where('song_id', $song_id)
                ->first();
            if(isset($status)) {
                $statusId =  $status->id;
                $nowState = $status->state;
            } else {
                $statusId = null;
                $nowState = 0;
            }
            if($nowState == $state) {
                throw new Exception('変更前と変更後のステータスが同じです');
            }
            
            if($nowState == 0) { 
                // ステータスの追加
                if(!Song::where('id', $song_id)->exists()) {
                    $song = Puller::lookSong($song_id);
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
                    'song_id' => $song_id,
                    'state' => $state
                ]);
                $user[$statusArray[$state - 1] . '_count'] += 1;

            } elseif($state != 0) { 
                // ステータスの更新
                Status::find($statusId)->update([
                    'state' => $state,
                    'used_at' => Carbon::now()
                ]);
                $user["{$statusArray[$state - 1]}_count"] += 1;
                $user["{$statusArray[$nowState - 1]}_count"] -= 1;

            } else { 
                // ステータスの削除
                Status::find($statusId)->delete();
                $user["{$statusArray[$nowState - 1]}_count"] -= 1;
                
            }
            Activity::createActivity($user->id, $song_id, $nowState, $state);
            $user["record_count"] += 1;
            
            $user->save();
            DB::commit();
            return [
                'id' => $song_id,
                'old_state' => $nowState,
                'new_state' => $state,
                'user' => $user
            ];
        } catch (Exception $e){
            DB::rollBack();
            throw new HttpResponseException(response()->json(['errors' => $e->getMessage()], 422));
        }
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