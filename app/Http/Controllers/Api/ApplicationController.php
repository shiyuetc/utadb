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

    /**
     * Return analysis data of user.
     * 
     * @param Request $request
     * @return array $response
     */
    public function analysis(Request $request)
    {
        $response = [];
        $response['rate'] = Status::select(['artist', DB::raw('count(*) as count')])
            ->where('statuses.user_id', $request->id)
            ->join('songs', 'statuses.song_id', 'songs.id')
            ->orderBy('count', 'desc')
            ->groupBy('artist')
            ->limit(5)
            ->get();

        for($i = 5; $i >= 0; $i--) {
            $response['activity'][Carbon::now()->subMonth($i)->month] = 0;
        }
        $month_total = Post::select([DB::raw("DATE_FORMAT(created_at,'%c') as date"), DB::raw('count(*) as count')])
            ->where('user_id', $request->id)
            ->where('created_at', '>=', Carbon::now()->subMonth(5)->format('Y-m-01'))
            ->groupBy('date')
            ->get();
        foreach($month_total as $total) {
            $response['activity'][$total['date']] = $total['count'];
        }

        return response()->json($response)->setStatusCode(200);
    }

}
