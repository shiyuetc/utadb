<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function showExport(Request $request)
    {
        $response = [];
        $state = $request->query('state', 0);
        if(!is_numeric($state) || $state > 3 || $state < 0) $state = 0;
        $sort = $request->query('sort', 'artist_asc');

        $query = Status::select('statuses.song_id')
            ->where('statuses.user_id', auth()->user()->id);

        if($state != 0) $query = $query->where('statuses.state', $state);

        switch($sort) {
            default:
                $query = $query->orderBy('artist', 'asc');
                break;
            case 'artist_desc':
                $query = $query->orderBy('artist', 'desc');
                break;
            case 'title_asc':
                $query = $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query = $query->orderBy('title', 'desc');
                break;
        }
        
        $temp_response = $query
            ->with('song')
            ->join('songs', 'statuses.song_id', 'songs.id')
            ->limit(10000)
            ->get();

        foreach($temp_response as $temp) {
            $response[] = $temp->song;
        }

        $options = ['state' => $state, 'sort' => $sort];
        return view('pages.tools.export', ['options' => $options, 'data' => $response]);
    }
    
}
