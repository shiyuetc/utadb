<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class ApplicationController extends ApiController
{   
    /**
     * Return all user count and all post count.
     * 
     * @return array $response
     */
    public function resourceCount()
    {
        return response()->json([
            'user_count' => User::count(),
            'post_count' => Post::count()
        ])->setStatusCode(200);
    }

    public function artistRate(Request $request)
    {
        $response = Status::select(['artist', DB::raw('count(*) as count')])
            ->where('statuses.user_id', $request->id)
            ->join('songs', 'statuses.song_id', 'songs.id')
            ->orderBy('count', 'desc')
            ->groupBy('artist')
            ->limit(10)
            ->get();

        return response()->json($response)->setStatusCode(200);
    }
}
