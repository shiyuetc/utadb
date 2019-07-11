<?php

namespace App\Http\Controllers\Api;

use App\Libraries\SongPuller\Puller;
use App\Models\Song;
use App\Models\Status;
use Illuminate\Http\Request;
use DB;

class SongController extends ApiController
{   
    /**
     * Get song from local and global database.
     * 
     * @param Request $request
     * @return array $response
     */
    public function index(Request $request)
    {
        // Use validation.
        $this->QueryValidate($request, [
            'type' => 'sometimes|string|in:title,artist',
            'source' => 'nullable|numeric|between:-1,1',
            'keyword' => 'required|string|between:1,20',
            'page' => 'nullable|numeric|between:1,9999',
            'per_page' => 'nullable|numeric|between:1,20',
        ]);

        // Declare variable.
        $response = [];
        $type = $request->query('type', 'title');
        $source = $request->query('source', -1);
        $keyword = $request->keyword;
        $page = $request->query('page', 1);
        $per_page = $request->query('per_page', 20);

        if($type == 'title') { // Searching from song title or artist name.
            if($source == -1) { // From local database.
                $response = Song::where('title', 'like', "%{$keyword}%")
                    ->orWhere('artist', 'like', "%{$keyword}%")
                    ->orderBy('title')
                    ->skip(($page - 1) * $per_page)
                    ->take($per_page)
                    ->get();
            } else { // From global database.
                $response = Puller::searchSong($source, $keyword, $page);
            }
        } elseif($type == 'artist') { // Searching from artist id.
            if($source == -1) { // From local database.
                $response = Song::Where('artist_id', $keyword)
                    ->orderBy('title')
                    ->skip(($page - 1) * $per_page)
                    ->take($per_page)
                    ->get();
            } else { // From gloval database.
                $response = Puller::searchSongFromArtist($keyword, $page);
            }
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
        // Use validation.
        $this->QueryValidate($request, [
            'state' => 'nullable|numeric|between:0,3',
            'keyword' => 'sometimes|string|between:1,20',
            'page' => 'nullable|numeric|between:1,9999',
            'per_page' => 'nullable|numeric|between:1,50',
        ]);

        // Checking if user exist.
        if(!DB::table('users')->where('id', $id)->exists()) {
            $this->CallException(__('passwords.user'), 404);
        }

        // Declare variable.
        $response = [];
        $state = $request->query('state', 0);
        $keyword = $request->query('keyword', null);
        $page = $request->query('page', 1);
        $per_page = $request->query('per_page', 50);

        $query = Status::select('statuses.song_id')
            ->where('statuses.user_id', $id);

        // Filter by select state.
        if($state != 0) $query = $query->where('statuses.state', $state);

        // Filter by keyword.
        if(!is_null($keyword)) {
            $query = $query->where(function($where) use (&$keyword) {
                $where->where('songs.title', 'like', "%{$keyword}%")
                ->orWhere('songs.artist', 'like', "%{$keyword}%");
            });
        }

        // Send query.
        $temp_response = $query
            ->with('song')
            ->join('songs', 'statuses.song_id', 'songs.id')
            ->orderBy('artist')
            ->skip(($page - 1) * $per_page)
            ->take($per_page)
            ->get();

        // Take out the contents.
        foreach($temp_response as $temp) {
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
        // Use validation.
        $this->QueryValidate($request, [
            'page' => 'nullable|numeric|between:1,9999',
            'per_page' => 'nullable|numeric|between:1,50',
        ]);

        // Checking if user exist.
        if(!DB::table('users')->where('id', $id)->exists()) {
            $this->CallException(__('passwords.user'), 404);
        }

        // Declare variable.
        $response = [];
        $page = $request->query('page', 1);
        $per_page = $request->query('per_page', 50);

        // Send query.
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

        // Take out the contents.
        foreach($temp_response as $temp) {
            $response[] = $temp->song;
        }

        return response()->json($response)->setStatusCode(200);
    }
    
}
