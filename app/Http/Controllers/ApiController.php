<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Status;

class ApiController extends Controller
{
    public function publicTimeline()
    {
        $statuses = Status::select('user_statuses.id', 'user_statuses.user_id', 'user_statuses.song_id', 'user_statuses.state', DB::raw('IFNULL(s1.state, 0) as user_state'), 'user_statuses.used_at')
        ->leftjoin('user_statuses as s1', function($join) {
            $join->where('s1.user_id', Auth::id())
            ->on('user_statuses.song_id', '=', 's1.song_id');
        })
        ->with(['user', 'song'])
        ->orderBy('used_at', 'desc')
        ->get();
            
        return response()->json($statuses);
    }
}
