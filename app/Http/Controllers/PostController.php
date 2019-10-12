<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use DB;

class PostController extends Controller
{
    public function index($id)
    {
        $post = Post::select('posts.id', 'posts.user_id', 'posts.song_id', 'posts.old_state', 'posts.state', DB::raw('IFNULL(statuses.state, 0) as my_state'),  DB::raw('IFNULL(posts.like_count, 0) as like_count'), DB::raw('IF(likes.id IS NOT NULL, 1, 0) as is_liked'), 'posts.created_at')
        ->leftjoin('statuses', function($join) {
            $join->where('statuses.user_id', auth()->id())
            ->on('posts.song_id', '=', 'statuses.song_id');
        })
        ->leftjoin('likes', function($join2) {
            $join2->where('likes.user_id', auth()->id())
            ->on('posts.id', '=', 'likes.post_id');
        })
        ->where('posts.id', '=', $id)
        ->with(['user', 'song'])
        ->first();
        
        if(is_null($post)) {
            return view('errors.404');
        }
        return view('pages.post', ['status' => $post]);
    }
}
