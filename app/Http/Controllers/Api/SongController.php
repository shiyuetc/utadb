<?php

namespace App\Http\Controllers\Api;

use App\Libraries\SongPuller\Puller;
use App\Models\Song;
use App\Models\Status;
use Illuminate\Http\Request;
use DB;

class SongController extends ApiController
{   
    private function mergeState(&$response)
    {
        $song_ids = [];
        foreach($response as $song) {
            $song_ids[] = $song["id"];
        }
        
        $states = Status::select('song_id', DB::raw('IFNULL(state, 0) as my_state'))
            ->where('user_id', auth()->id())
            ->whereIn('song_id', $song_ids)
            ->get();
        $temp_my_state = [];
        foreach($states as $state)
        {
            $temp_my_state[$state->song_id] = $state->my_state;
        }

        $temp_response = $response;
        $response = [];
        foreach($temp_response as $temp)
        {
            $temp['my_state'] = $temp_my_state[$temp['id']] ?? 0;
            $response[] = $temp;
        }
    }

    /**
     * Get song from local and global database.
     * 
     * @param Request $request
     * @return array $response
     */
    public function index(Request $request)
    {
        $this->QueryValidate($request, [
            'type' => 'sometimes|string|in:title,artist',
            'source' => 'nullable|numeric|between:-1,1',
            'id' => 'required_if:type,artist|string|between:1,20',
            'keyword' => 'required_unless:type,artist|string|between:1,20',
            'page' => 'nullable|numeric|between:1,9999',
            'per_page' => 'nullable|numeric|between:1,20',
            'with_state' => 'sometimes|boolean'
        ]);
            
        $response = [];
        $type = $request->query('type', 'title');
        $source = $request->query('source', -1);
        $id = $request->query('id', null);
        $keyword = $request->query('keyword', null);
        $page = $request->query('page', 1);
        $per_page = $request->query('per_page', 20);
        $with_state = $request->query('with_state', false);

        if($type == 'title') { // Searching from song title or artist name.
            if($source == -1) {
                $response = Song::where('title', 'like', "%{$keyword}%")
                    ->orWhere('artist', 'like', "%{$keyword}%")
                    ->orderBy('title')
                    ->skip(($page - 1) * $per_page)
                    ->take($per_page)
                    ->get();
            } else {
                $response = Puller::searchSong($source, $keyword, $page);
            }
        } elseif($type == 'artist') { // Searching from artist id.
            if($source == -1) {
                $response = Song::Where('artist_id', $id)
                    ->orderBy('title')
                    ->skip(($page - 1) * $per_page)
                    ->take($per_page)
                    ->get();
            } else {
                $response = Puller::searchSongFromArtist($id, $page);
            }
        }

        if($with_state && count($response) > 0) {
            $this->mergeState($response);
        }

        return response()->json($response)->setStatusCode(200);
    }

    /**
     * Get song from registered song list.
     * 
     * @param Request $request
     * @return array $response
     */
    public function user(Request $request, $id)
    {
        $this->QueryValidate($request, [
            'state' => 'nullable|numeric|between:0,3',
            'keyword' => 'sometimes|string|between:1,20',
            'page' => 'nullable|numeric|between:1,9999',
            'per_page' => 'nullable|numeric|between:1,50',
            'with_state' => 'sometimes|boolean'
        ]);

        if(!DB::table('users')->where('id', $id)->exists()) {
            $this->CallException(__('passwords.user'), 404);
        }

        $response = [];
        $state = $request->query('state', 0);
        $keyword = $request->query('keyword', null);
        $page = $request->query('page', 1);
        $per_page = $request->query('per_page', 50);
        $with_state = $request->query('with_state', false);

        $selectColumn = [];
        $selectColumn[] = 'statuses.song_id';
        if($with_state) $selectColumn[] = DB::raw('IFNULL(s1.state, 0) as my_state');

        $query = Status::select($selectColumn)
            ->where('statuses.user_id', $id);

        // ステータスの絞り込み
        if($state != 0) $query = $query->where('statuses.state', $state);

        // キーワード検索
        if(!is_null($keyword)) {
            $query = $query->where(function($where) use (&$keyword) {
                $where->where('songs.title', 'like', "%{$keyword}%")
                ->orWhere('songs.artist', 'like', "%{$keyword}%");
            });
        }

        if($with_state) {
            $query = $query->leftjoin('statuses as s1', function($join) {
                $join->where('s1.user_id', auth()->id())
                ->on('statuses.song_id', '=', 's1.song_id');
            });
        }

        $temp_response = $query
            ->with('song')
            ->join('songs', 'statuses.song_id', 'songs.id')
            ->orderBy('artist')
            ->skip(($page - 1) * $per_page)
            ->take($per_page)
            ->get();

        foreach($temp_response as $temp) {
            if($with_state) $temp->song->my_state = $temp->my_state;
            $response[] = $temp->song;
        }
            
        return response()->json($response)->setStatusCode(200);
    }

    /**
     * Get song from common song list.
     * 
     * @param Request $request
     * @return array $response
     */
    public function common(Request $request, $id)
    {
        $this->QueryValidate($request, [
            'page' => 'nullable|numeric|between:1,9999',
            'per_page' => 'nullable|numeric|between:1,50',
            'with_state' => 'sometimes|boolean'
        ]);

        if(!DB::table('users')->where('id', $id)->exists()) {
            $this->CallException(__('passwords.user'), 404);
        }

        $response = [];
        $page = $request->query('page', 1);
        $per_page = $request->query('per_page', 50);
        $with_state = $request->query('with_state', false);

        $temp_response = Status::select('statuses.song_id')
            ->join('statuses as s1', function($join) {
                $join->where('s1.user_id', auth()->id())
                ->where('s1.state', 3)
                ->on('statuses.song_id', 's1.song_id');
            })
            ->where('statuses.user_id', $id)
            ->where('statuses.state', 3)
            ->with('song')
            ->join('songs', 'statuses.song_id', 'songs.id')
            ->orderBy('artist')
            ->skip(($page - 1) * $per_page)
            ->take($per_page)
            ->get();

        foreach($temp_response as $temp) {
            if($with_state) $temp->song->my_state = 3;
            $response[] = $temp->song;
        }

        return response()->json($response)->setStatusCode(200);
    }

    /**
     * Get ranked song list.
     * 
     * @return array $response
     */
    public function ranking()
    {
        $response = Puller::getRanking();
        if(count($response) > 0) {
            $this->mergeState($response);
        }

        return response()->json($response)->setStatusCode(200);
    }

    /**
     * Get recent released song list.
     * 
     * @return array $response
     */
    public function recent()
    {
        $response = Puller::getRecent();
        if(count($response) > 0) {
            $this->mergeState($response);
        }

        return response()->json($response)->setStatusCode(200);
    }

}
