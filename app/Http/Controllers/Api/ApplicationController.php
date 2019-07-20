<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
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
            ->limit(5)
            ->get();

        return response()->json($response)->setStatusCode(200);
    }

    public function activity(Request $request)
    {
        $response = [];
        for($i = 5; $i >= 0; $i--) {
            $response[Carbon::now()->subMonth($i)->month] = 0;
        }
        
        $month_total = Post::select([DB::raw("DATE_FORMAT(created_at,'%c') as date"), DB::raw('count(*) as count')])
            ->where('user_id', $request->id)
            ->where('created_at', '>=', Carbon::now()->subMonth(5)->format('Y-m-01'))
            ->groupBy('date')
            ->get();
        
        foreach($month_total as $total) {
            $response[$total['date']] = $total['count'];
        }

        return response()->json($response)->setStatusCode(200);
    }
}
