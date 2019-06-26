<?php

namespace App\Models;

use App\Models\Song;
use App\Libraries\SongPuller\Puller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;
use DB;
use Exception;

class Status extends Model
{
    protected $table = 'user_statuses';

    public $timestamps = false;

    public $incrementing = false;
    
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'state', 'used_at'
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
    
    public static function CreateId()
    {
        return str_pad(str_replace('.', '', microtime(true)), 14, '0', STR_PAD_RIGHT);
    }

    public static function CreateUserStatus($state, $id, $title, $artist, $image_url = null, $audio_url = null)
    {
        $song = Song::CreateSong($id, $title, $artist, $image_url, $audio_url);
        $status = new Status();
        $status->user_state = $state;
        $status->song = $song;
        return $status;
    }

    public static function showStatus($song_id)
    {
        $song = Puller::lookSong($song_id);
        if(!is_null($song)) {
            $state = Status::select('state')
                ->where('user_id', auth()->id())
                ->where('song_id', $song_id)
                ->first();
            $user_state = $state != null ? $state['state'] : 0;
            $status = Status::CreateUserStatus($user_state, $song["id"], $song["title"], $song["artist"], $song["image_url"], $song["audio_url"]);
        } else {
            $status = Status::select('user_statuses.song_id', DB::raw('IFNULL(s1.state, 0) as user_state'))
                ->leftjoin('user_statuses as s1', function($join) {
                    $join->where('s1.user_id', auth()->id())
                    ->on('user_statuses.song_id', '=', 's1.song_id');
                })
                ->where('user_statuses.song_id', $song_id)
                ->with('song')
                ->first();
        }
        return isset($status) ? $status : null;
    }

    public static function statusLookup($song_id)
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

    public static function statusUpdate($song_id, $state) 
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
                ->where('song_id', $song_id)
                ->first();
            $statusId = isset($status) ? $status->id : null;
            $nowState = isset($status) ? $status->state : 0;
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
                    'id' => Status::CreateId(),
                    'user_id' => $user->id,
                    'song_id' => $song_id,
                    'state' => $state
                ]);
                $user[$statusArray[$state - 1] . '_count'] += 1;

            } elseif($state != 0) { 
                // ステータスの更新
                Status::find($statusId)->update([
                    'id' => Status::CreateId(),
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

    public static function searchSong($source, $q, $page = 1)
    {
        $statuses = [];
        if($source == -1) {
            $songs = Song::where('title', 'like', "%{$q}%")
                ->orWhere('artist', 'like', "%{$q}%")
                ->orderBy('title')
                ->skip(($page - 1) * 10)
                ->take(10)
                ->get();
        } else {
            $songs = Puller::searchSong($source, $q, $page);
        }
        
        if(count($songs) > 0) {
            $song_ids = array();
            foreach($songs as $song) {
                $song_ids[] = $song["id"];
            }
            
            $states = Status::select('song_id', DB::raw('state as user_state'))
                ->where('user_id', auth()->id())
                ->whereIn('song_id', $song_ids)
                ->get();

            $temp_user_state = [];
            foreach($states as $state)
            {
                $temp_user_state[$state->song_id] = $state->user_state;
            }
            for($i = 0; $i < count($songs); $i++)
            {
                $statuses[] = [
                    'user_state' => isset($temp_user_state[$songs[$i]['id']]) ? $temp_user_state[$songs[$i]['id']] : 0,
                    'song' => $songs[$i]
                ];
            }
        }
        return $statuses;
    }

    public static function userCommon($id, $page = 1)
    {
        $query =  Status::select('user_statuses.song_id', DB::raw('s1.state as user_state'))
        ->join('user_statuses as s1', function($join) {
            $join->where('s1.user_id', auth()->id())
            ->where('s1.state', 3)
            ->on('user_statuses.song_id', '=', 's1.song_id');
        })
        ->where('user_statuses.user_id', $id)
        ->where('user_statuses.state', 3);

        return $query
            ->with('song')
            ->join('songs', 'user_statuses.song_id', '=', 'songs.id')
            ->orderBy('artist')
            ->skip(($page - 1) * 50)
            ->take(50)
            ->get();
    }

    public static function userStatuses($id, $state = 0, $page = 1, $q = null)
    {
        $query =  Status::select('user_statuses.song_id', DB::raw('IFNULL(s1.state, 0) as user_state'))
        ->leftjoin('user_statuses as s1', function($join) {
            $join->where('s1.user_id', auth()->id())
            ->on('user_statuses.song_id', '=', 's1.song_id');
        })
        ->where('user_statuses.user_id', $id);

        if($state != 0) $query = $query->where('user_statuses.state', $state);

        if(!empty($q)) {
            $query = $query->where(function($where) use (&$q) {
                $where->where('songs.title', 'like', "%{$q}%")
                ->orWhere('songs.artist', 'like', "%{$q}%");
            });
        }

        return $query
            ->with('song')
            ->join('songs', 'user_statuses.song_id', '=', 'songs.id')
            ->orderBy('artist')
            ->skip(($page - 1) * 50)
            ->take(50)
            ->get();
    }

    public static function getTimeline($id = null, $next = null)
    {
        $query = Status::select('user_statuses.id', 'user_statuses.user_id', 'user_statuses.song_id', 'user_statuses.state', DB::raw('IFNULL(s1.state, 0) as user_state'), 'user_statuses.used_at')
        ->leftjoin('user_statuses as s1', function($join) {
            $join->where('s1.user_id', auth()->id())
            ->on('user_statuses.song_id', '=', 's1.song_id');
        });

        if(!is_null($id)) $query = $query->where('user_statuses.user_id', $id);

        if(!is_null($next)) {
            $query = $query->where('user_statuses.id', '<', $next);
        } 

        return $query
            ->take(50)
            ->with(['user', 'song'])
            ->orderBy('id', 'desc')
            ->get();
    }
}