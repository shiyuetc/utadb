<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use DB;

class PostController extends ApiController
{
    /**
     * Get post array.
     * 
     * @param Request $request
     * @return array $response
     */
    public function index(request $request)
    {
        $this->QueryValidate($request, [
            'id' => 'nullable|numeric',
            'count' => 'nullable|numeric|between:1,50',
        ]);

        $user_id = $request->query('id', null);
        $next_id = $request->query('next', null);
        $count = $request->query('count', 50);

        $query = Post::select('posts.id', 'posts.user_id', 'posts.song_id', 'posts.old_state', 'posts.state', DB::raw('IFNULL(statuses.state, 0) as my_state'),  DB::raw('IFNULL(posts.like_count, 0) as like_count'), DB::raw('IF(likes.id IS NOT NULL, 1, 0) as is_liked'), 'posts.created_at')
        ->leftjoin('statuses', function($join) {
            $join->where('statuses.user_id', auth()->id())
            ->on('posts.song_id', '=', 'statuses.song_id');
        })
        ->leftjoin('likes', function($join2) {
            $join2->where('likes.user_id', auth()->id())
            ->on('posts.id', '=', 'likes.post_id');
        });

        // 対象のユーザーのみを取得
        if(!is_null($user_id)) $query = $query->where('posts.user_id', $user_id);

        // next以降のアクティビティを取得
        if(!is_null($next_id)) $query = $query->where('posts.id', '<', $next_id);

        $response = $query
            ->take($count)
            ->with(['user', 'song'])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($response)->setStatusCode(200);
    }
    
}
