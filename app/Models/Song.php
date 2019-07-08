<?php

namespace App\Models;

use App\Models\Status;
use App\Libraries\SongPuller\Puller;
use Illuminate\Database\Eloquent\Model;
use DB;

class Song extends Model
{
    protected $table = 'songs';

    public $timestamps = false;
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at'
    ];

    // 曲の検索
    public static function search($source, $q, $page = 1)
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
            
            $states = Status::select('song_id', DB::raw('state as my_state'))
                ->where('user_id', auth()->id())
                ->whereIn('song_id', $song_ids)
                ->get();

            $temp_my_state = [];
            foreach($states as $state)
            {
                $temp_my_state[$state->song_id] = $state->my_state;
            }
            for($i = 0; $i < count($songs); $i++)
            {
                $statuses[] = [
                    'my_state' => isset($temp_my_state[$songs[$i]['id']]) ? $temp_my_state[$songs[$i]['id']] : 0,
                    'song' => $songs[$i]
                ];
            }
        }
        return $statuses;
    }

    public static function searchFromArtist($source, $artist_id, $page = 1)
    {
        $statuses = [];
        if($source == -1) {
            $songs = Song::Where('artist_id', $artist_id)
                ->orderBy('title')
                ->skip(($page - 1) * 10)
                ->take(10)
                ->get();
        } else {
            $songs = Puller::searchSongFromArtist($artist_id, $page);
        }
        
        if(count($songs) > 0) {
            $song_ids = array();
            foreach($songs as $song) {
                $song_ids[] = $song["id"];
            }
            
            $states = Status::select('song_id', DB::raw('state as my_state'))
                ->where('user_id', auth()->id())
                ->whereIn('song_id', $song_ids)
                ->get();

            $temp_my_state = [];
            foreach($states as $state)
            {
                $temp_my_state[$state->song_id] = $state->my_state;
            }
            for($i = 0; $i < count($songs); $i++)
            {
                $statuses[] = [
                    'my_state' => isset($temp_my_state[$songs[$i]['id']]) ? $temp_my_state[$songs[$i]['id']] : 0,
                    'song' => $songs[$i]
                ];
            }
        }
        return $statuses;
    }

    // 引数のユーザーと共に習得済みに登録している曲の配列を返す
    public static function userCommon($id, $page = 1)
    {
        $query =  Status::select('statuses.song_id', DB::raw('s1.state as my_state'))
        ->join('statuses as s1', function($join) {
            $join->where('s1.user_id', auth()->id())
            ->where('s1.state', 3)
            ->on('statuses.song_id', '=', 's1.song_id');
        })
        ->where('statuses.user_id', $id)
        ->where('statuses.state', 3);

        return $query
            ->with('song')
            ->join('songs', 'statuses.song_id', '=', 'songs.id')
            ->orderBy('artist')
            ->skip(($page - 1) * 50)
            ->take(50)
            ->get();
    }

    // 引数のユーザーが登録している曲の配列を返す
    public static function userStatuses($id, $state = 0, $page = 1, $q = null)
    {
        $query =  Status::select('statuses.song_id', DB::raw('IFNULL(s1.state, 0) as my_state'))
        ->leftjoin('statuses as s1', function($join) {
            $join->where('s1.user_id', auth()->id())
            ->on('statuses.song_id', '=', 's1.song_id');
        })
        ->where('statuses.user_id', $id);

        // 対象の状態を取得
        if($state != 0) $query = $query->where('statuses.state', $state);

        // キーワードからの絞り込み
        if(!is_null($q)) {
            $query = $query->where(function($where) use (&$q) {
                $where->where('songs.title', 'like', "%{$q}%")
                ->orWhere('songs.artist', 'like', "%{$q}%");
            });
        }

        return $query
            ->with('song')
            ->join('songs', 'statuses.song_id', '=', 'songs.id')
            ->orderBy('artist')
            ->skip(($page - 1) * 50)
            ->take(50)
            ->get();
    }
}
