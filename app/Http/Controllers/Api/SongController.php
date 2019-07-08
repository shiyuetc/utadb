<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ApiRequestRules;
use App\Libraries\SongPuller\Puller;
use App\Models\Song;
use App\Models\Status;
use Illuminate\Http\Request;
use DB;

class SongController extends ApiController
{   
    public function search(Request $request)
    {
        $this->QueryValidate($request, [
            'source' => ApiRequestRules::getSourceRule(),
            'q' => ApiRequestRules::getQRule(),
            'page' => ApiRequestRules::getPageRule(),
        ]);
        
        $response = [];
        if($request->source == -1) {
            $songs = Song::where('title', 'like', "%{$request->q}%")
                ->orWhere('artist', 'like', "%{$request->q}%")
                ->orderBy('title')
                ->skip(($request->query('page', 1) - 1) * 10)
                ->take(10)
                ->get();
        } else {
            $songs = Puller::searchSong($request->source, $request->q, $request->query('page', 1));
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
                $response[] = [
                    'my_state' => isset($temp_my_state[$songs[$i]['id']]) ? $temp_my_state[$songs[$i]['id']] : 0,
                    'song' => $songs[$i]
                ];
            }
        }

        return response()->json($response)->setStatusCode(200);
    }
    
    public function searchFromArtist(Request $request)
    {
        $this->QueryValidate($request, [
            'page' => ApiRequestRules::getPageRule(),
        ]);
        
        $response = [];
        if($request->source == -1) {
            $songs = Song::Where('artist_id', $request->artist_id)
                ->orderBy('title')
                ->skip(($request->query('page', 1) - 1) * 10)
                ->take(10)
                ->get();
        } else {
            $songs = Puller::searchSongFromArtist($request->artist_id, $request->query('page', 1));
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
                $response[] = [
                    'my_state' => isset($temp_my_state[$songs[$i]['id']]) ? $temp_my_state[$songs[$i]['id']] : 0,
                    'song' => $songs[$i]
                ];
            }
        }

        return response()->json($response)->setStatusCode(200);
    }
    
    public function userCommon(Request $request)
    {
        $this->QueryValidate($request, [
            'id' => ApiRequestRules::getUserIdRule(),
            'page' => ApiRequestRules::getPageRule(),
        ]);

        $response = Status::select('statuses.song_id', DB::raw('s1.state as my_state'))
        ->join('statuses as s1', function($join) {
            $join->where('s1.user_id', auth()->id())
            ->where('s1.state', 3)
            ->on('statuses.song_id', '=', 's1.song_id');
        })
        ->where('statuses.user_id', $request->id)
        ->where('statuses.state', 3)
        ->with('song')
        ->join('songs', 'statuses.song_id', '=', 'songs.id')
        ->orderBy('artist')
        ->skip(($request->query('page', 1) - 1) * 50)
        ->take(50)
        ->get();

        return response()->json($response)->setStatusCode(200);
    }

    public function userStatuses(Request $request)
    {
        $this->QueryValidate($request, [
            'id' => ApiRequestRules::getUserIdRule(),
            'state' => ApiRequestRules::getStateRule(),
            'page' => ApiRequestRules::getPageRule(),
        ]);

        $query = Status::select('statuses.song_id', DB::raw('IFNULL(s1.state, 0) as my_state'))
        ->leftjoin('statuses as s1', function($join) {
            $join->where('s1.user_id', auth()->id())
            ->on('statuses.song_id', '=', 's1.song_id');
        })
        ->where('statuses.user_id', $request->id);

        // 対象の状態を取得
        if($request->state != 0) $query = $query->where('statuses.state', $request->state);

        // キーワードからの絞り込み
        if(!is_null($request->q)) {
            $q = $request->q;
            $query = $query->where(function($where) use (&$q) {
                $where->where('songs.title', 'like', "%{$q}%")
                ->orWhere('songs.artist', 'like', "%{$q}%");
            });
        }

        $response = $query
            ->with('song')
            ->join('songs', 'statuses.song_id', '=', 'songs.id')
            ->orderBy('artist')
            ->skip(($request->query('page', 1) - 1) * 50)
            ->take(50)
            ->get();
            
        return response()->json($response)->setStatusCode(200);
    }
}
